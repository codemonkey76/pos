<?php

namespace App\Http\Controllers;

use http\Exception;
use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Error\ApiConnection;
use Stripe\Error\Authentication;
use Stripe\Error\Base;
use Stripe\Error\Card;
use Stripe\Error\InvalidRequest;
use Stripe\Error\RateLimit;
use Stripe\Stripe;
use Stripe\Token;

class StripeController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function charge(Request $request)
    {
        try {
            // Use stripe's library to make requests...
            $token = Token::create([
                'card' => [
                    'number' => $request->card['card_number'],
                    'exp_month' => $request->card['expiry_month'],
                    'exp_year' => $request->card['expiry_year'],
                    'cvc' => $request->card['cvv']
                ]
            ]);

            Charge::create([
               'amount' => $request->amount * 100,
               'currency' => 'AUD',
               'source' => $token,
               'description' => $request->description,
               'receipt_email' => $request->email
            ]);

            return response()->json([
                'success' => true
            ]);
        } catch(Card $e) {
            //Since it's a decline, Card will be caught
            return response()->json($e->getJsonBody());
        } catch (RateLimit $e) {
            // Too many requests made to the API too quickly
            return response()->json($e->getJsonBody());
        } catch (InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            return response()->json($e->getJsonBody());
        } catch (Authentication $e) {
            // Authentication with Stripe's API failed
            return response()->json($e->getJsonBody());
        } catch (ApiConnection $e) {
            // Network communication with Stripe failed
            return response()->json($e->getJsonBody());
        } catch (Base $e) {
            // Generic Error
            return response()->json($e->getJsonBody());
        } catch (Exception $e) {
            // Something else happened
            return response()->json($e->getJsonBody());
        }
    }
}
