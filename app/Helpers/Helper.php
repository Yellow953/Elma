<?php

namespace App\Helpers;

use App\Models\Account;
use App\Models\Client;
use App\Models\Currency;
use App\Models\SearchRoute;
use App\Models\Tax;
use App\Models\Item;
use App\Models\Variable;
use NumberToWords\NumberToWords;

class Helper
{
    public static function get_items()
    {
        return Item::select('id', 'name')->get();
    }

    public static function get_currencies()
    {
        return Currency::select('id', 'code', 'symbol', 'rate')->get();
    }

    public static function get_taxes()
    {
        return Tax::select('id', 'name', 'rate')->get();
    }

    public static function convert($currency_id, $number)
    {
        return Currency::find($currency_id)->rate * $number;
    }

    public static function get_clients()
    {
        try {
            return Client::select('id', 'name')->orderBy('created_at', 'ASC')->get();
        } catch (\Throwable $th) {
            session()->flash('error', 'No Clients in our database!');
        }
    }

    public static function get_accounts()
    {
        return Account::select('id', 'account_number', 'account_description')->get();
    }

    public static function get_countries()
    {
        $countries = ["Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Anguilla", "Antigua &amp; Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia &amp; Herzegovina", "Botswana", "Brazil", "British Virgin Islands", "Brunei", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Cape Verde", "Cayman Islands", "Chad", "Chile", "China", "Colombia", "Congo", "Cook Islands", "Costa Rica", "Cote D Ivoire", "Croatia", "Cruise Ship", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Estonia", "Ethiopia", "Falkland Islands", "Faroe Islands", "Fiji", "Finland", "France", "French Polynesia", "French West Indies", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guam", "Guatemala", "Guernsey", "Guinea", "Guinea Bissau", "Guyana", "Haiti", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Isle of Man", "Israel", "Italy", "Jamaica", "Japan", "Jersey", "Jordan", "Kazakhstan", "Kenya", "Kuwait", "Kyrgyz Republic", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Mauritania", "Mauritius", "Mexico", "Moldova", "Monaco", "Mongolia", "Montenegro", "Montserrat", "Morocco", "Mozambique", "Namibia", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Norway", "Oman", "Pakistan", "Palestine", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russia", "Rwanda", "Saint Pierre &amp; Miquelon", "Samoa", "San Marino", "Satellite", "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "South Africa", "South Korea", "Spain", "Sri Lanka", "St Kitts &amp; Nevis", "St Lucia", "St Vincent", "St. Lucia", "Sudan", "Suriname", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Timor L'Este", "Togo", "Tonga", "Trinidad &amp; Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks &amp; Caicos", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "Uruguay", "Uzbekistan", "Venezuela", "Vietnam", "Virgin Islands (US)", "Yemen", "Zambia", "Zimbabwe"];

        return $countries;
    }

    public static function get_account_types()
    {
        $accountTypes = [
            'Balance Sheet',
            'P/L',
        ];

        return $accountTypes;
    }

    public static function get_payment_types()
    {
        $paymentTypes = [
            'payment',
            'return'
        ];

        return $paymentTypes;
    }

    public static function format_text($text)
    {
        $text = str_replace('_', ' ', $text);
        $text = ucwords($text);
        return $text;
    }

    public static function get_route_names()
    {
        return SearchRoute::pluck('name')->toArray();
    }

    public static function format_currency_to_words($amount)
    {
        $amount = str_replace([',', '$'], '', $amount);
        $parts = explode('.', $amount);
        $dollars = (int) $parts[0];

        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('en');

        $words = $numberTransformer->toWords($dollars);

        return 'Only ' . ucfirst($words) . ' US Dollar' . ($dollars > 1 ? 's' : '');
    }

    public static function get_shipping_modes()
    {
        return ['Air', 'Sea', 'Land'];
    }

    public static function get_shipping_ports()
    {
        return Variable::where('type', 'ports')->get()->pluck('title');
    }

    public static function get_order_statuses()
    {
        return ['New', 'Ongoing', 'Closed'];
    }

    public static function get_expense_types()
    {
        return ['Salary', 'Rent', 'Utility', 'Other Expenses'];
    }
}
