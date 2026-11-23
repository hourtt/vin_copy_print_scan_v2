<?php

namespace App\Enums;

enum CategoryType: string
{
    case Printer = 'printer';
    case Toner = 'toner';
    case Ink = 'ink';
    case Paper = 'paper';
    case Accessories = 'accessories';
}
