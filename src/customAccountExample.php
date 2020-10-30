<?php
require_once('vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->load();

\Stripe\Stripe::setMaxNetworkRetries(3);
$stripe = new \Stripe\StripeClient($_ENV['STRIPE_API_KEY']);

$account_token = $stripe->tokens->create([
  'account' => [
    'company' => [
      'name' => 'Company Name',
      'phone' => '0603229127',
      'tax_id' => '123123123',
      'address' => [
        'city' => 'Libourne',
        'country' => 'FR',
        'line1' => '52 rue de Paris',
        'postal_code' => '33500',
        'state' => 'Libourne',
      ],
    ],
    'business_type' => 'company',
    'tos_shown_and_accepted' => 'true',
  ],
]);

echo $account_token;

$account = $stripe->accounts->create([
  'country' => 'FR',
  'type' => 'custom',
  'account_token' => $account_token->id,
  'requested_capabilities' => ['0' => 'card_payments', '1' => 'transfers'],
  'settings' => ['payouts' => ['schedule' => ['interval' => 'manual']]],
]);

echo "\n\nAccount: ";
echo $account;


$account_link = $stripe->accountLinks->create([
  'account' => $account->id,
  'refresh_url' => 'https://example.com/reauth',
  'return_url' => 'https://example.com/return',
  'type' => 'account_onboarding',
]);

echo "\n\nAccount Link: ";
echo $account_link;
echo "\n\n";
echo $account_link->url;
echo "\n\n";
