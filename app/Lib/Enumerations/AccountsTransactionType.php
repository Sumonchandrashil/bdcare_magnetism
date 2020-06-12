<?php
namespace App\Lib\Enumerations;

class AccountsTransactionType
{
    public static $journal = 1;
    public static $contra = 2;
    public static $cashPayment = 3;
    public static $bankPayment = 4;
    public static $cashReceipt = 5;
    public static $bankReceipt = 6;
    public static $bankTransfer = 7;

    public static $salesInvVoucer = 8;
    public static $salesInvRtnVoucer = 9;
    public static $purchaseInvVoucer = 10;
    public static $purchaseInvRtnVoucer = 11;
}
