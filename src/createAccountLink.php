<?php
require_once('vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->load();

\Stripe\Stripe::setMaxNetworkRetries(3);
$stripe = new \Stripe\StripeClient($_ENV['STRIPE_API_KEY']);

$account_link = $stripe->accountLinks->create([
  'account' => "acct_1HhvZsFCkJHhVzMh",
  'refresh_url' => 'https://example.com/reauth',
  'return_url' => 'https://example.com/return',
  'type' => 'account_onboarding',
]);

echo "\n\nAccount Link: ";
echo $account_link;
echo "\n\n";
echo $account_link->url;
echo "\n\n";
