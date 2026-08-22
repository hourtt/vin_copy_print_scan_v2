<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InquiryController extends Controller
{
    /**
     * Store a new inquiry and return the Telegram deep-link URL.
     *
     * Flow:
     *   1. Authenticate (handled by ['auth','user'] middleware on the route).
     *   2. If the user has no phone number, return a JSON signal so Alpine
     *      can open the phone-number prompt modal.
     *   3. Build the Telegram prefill message in the chosen language.
     *   4. Persist a snapshot row so the admin log is accurate long-term.
     *   5. Return the Telegram URL — JS opens it in a new tab.
     */
    public function store(Request $request, Product $product): JsonResponse
    {
        $user = $request->user();

        // ── Phone-number gate ──────────────────────────────────────────────
        if (empty($user->phone_number)) {
            return response()->json(['needs_phone' => true]);
        }

        // ── Validate language input ────────────────────────────────────────
        $language = in_array($request->input('language'), ['en', 'km', 'zh'])
            ? $request->input('language')
            : 'en';

        // ── Build prefill message ──────────────────────────────────────────
        $text = $this->buildMessage($user, $product, $language);

        // ── Build Telegram deep-link ───────────────────────────────────────
        $username = config('services.telegram.owner_username');
        $telegramUrl = 'https://t.me/' . ltrim($username, '@')
                       . '?text=' . rawurlencode($text);

        // ── Persist inquiry snapshot (best-effort — never block the redirect) ──
        try {
            Inquiry::create([
                'user_id'                => $user->id,
                'product_id'             => $product->id,
                'product_name_snapshot'  => $product->name,
                'product_price_snapshot' => $product->discount_price ?? $product->price,
                'user_name_snapshot'     => trim("{$user->first_name} {$user->last_name}"),
                'user_email_snapshot'    => $user->email,
                'user_phone_snapshot'    => $user->phone_number,
                'language'               => $language,
            ]);
        } catch (\Throwable $e) {
            \Log::error('Inquiry persistence failed', [
                'user_id'    => $user->id,
                'product_id' => $product->id,
                'error'      => $e->getMessage(),
            ]);
        }

        return response()->json(['telegram_url' => $telegramUrl]);
    }

    /**
     * Display the authenticated customer's inquiry history.
     */
    public function history(Request $request): View
    {
        $inquiries = Inquiry::where('user_id', $request->user()->id)
            ->with('product')
            ->latest()
            ->paginate(10);

        return view('profile.inquiries.index', compact('inquiries'));
    }

    // ────────────────────────────────────────────────────────────────────────
    // Private helpers
    // ────────────────────────────────────────────────────────────────────────

    /**
     * Build the Telegram prefill message in the selected language.
     */
    private function buildMessage(User $user, Product $product, string $language): string
    {
        $name    = trim("{$user->first_name} {$user->last_name}");
        $phone   = $user->phone_number;
        $email   = $user->email;
        $pName   = $product->name;
        $price   = number_format($product->discount_price ?? $product->price, 2);

        return match ($language) {
            'km' => implode("\n", [
                "សួស្ដី! ខ្ញុំឈ្មោះ {$name}។",
                "លេខទូរស័ព្ទ: {$phone}",
                "អ៊ីមែល: {$email}",
                "ខ្ញុំចាប់អារម្មណ៍លើ: {$pName} (\${$price})",
            ]),
            'zh' => implode("\n", [
                "你好！我是 {$name}。",
                "电话: {$phone}",
                "邮箱: {$email}",
                "我对以下产品感兴趣：{$pName}（\${$price}）",
            ]),
            default => implode("\n", [
                "Hi! I'm {$name}.",
                "Phone: {$phone}",
                "Email: {$email}",
                "I'm interested in: {$pName} (\${$price})",
            ]),
        };
    }
}
