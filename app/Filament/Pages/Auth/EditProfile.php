<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EditProfile extends BaseEditProfile
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Profile Information')
                    ->description('Update your account details and profile photo.')
                    ->icon('heroicon-m-user')
                    ->schema([
                        FileUpload::make('profile_image')
                            ->label('Avatar')
                            ->inlineLabel(false)
                            ->disk('public')
                            ->directory('profile_images')
                            ->image()
                            ->avatar()
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '1:1',
                            ])
                            ->columnSpanFull()
                            ->extraFieldWrapperAttributes([
                                'class' => '!flex !flex-col !items-center !gap-2 text-center',
                            ])
                            ->extraAttributes([
                                'class' => '!mx-auto',
                            ]),
                        Grid::make([
                            'default' => 1,
                            'sm' => 2,
                        ])
                            ->schema([
                                $this->compactTextField(
                                    TextInput::make('first_name')
                                        ->label('First Name')
                                        ->required()
                                        ->maxLength(255)
                                ),

                                $this->compactTextField(
                                    TextInput::make('last_name')
                                        ->label('Last Name')
                                        ->required()
                                        ->maxLength(255)
                                ),

                                $this->compactTextField(
                                    $this->getEmailFormComponent()
                                )
                                    ->columnSpanFull(),
                            ])
                            ->columnSpanFull(),
                    ]),

                Section::make('Update Password')
                    ->description('Ensure your account is using a long, random password to stay secure.')
                    ->icon('heroicon-m-key')
                    ->schema([
                        Grid::make(1)
                            ->extraAttributes([
                                'class' => '!gap-y-3',
                            ])
                            ->schema([
                                $this->compactTextField(
                                    $this->getPasswordFormComponent()
                                ),

                                $this->compactTextField(
                                    $this->getPasswordConfirmationFormComponent()
                                ),

                                $this->compactTextField(
                                    $this->getCurrentPasswordFormComponent()
                                ),
                            ]),
                    ]),
            ]);
    }

    protected function compactTextField($field)
    {
        return $field
            // Put the label above the input
            ->inlineLabel(false)

            // Limit the complete field width
            ->extraFieldWrapperAttributes([
                'class' => 'w-full max-w-md',
            ])

            // Make the input fill the limited wrapper width
            ->extraInputAttributes([
                'class' => 'w-full',
            ]);
    }
}
