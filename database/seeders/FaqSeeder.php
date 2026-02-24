<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    public function run()
    {
        $faqs = [

            [
                'exam_type_id' => null,
                'question' => 'I Was Debited But Payment Was Unsuccessful',
                'answer' => 'For issues with failed payment, please contact our customer support via the Whatsapp Icon on the Website.',
                'is_active' => true,
            ],

            [
                'exam_type_id' => null,
                'question' => 'How Long Will It Take My Scratch Card To Be Delivered?',
                'answer' => 'Scratch cards are delivered instantly on successful payment. Cards are also sent to the customers email address.',
                'is_active' => true,
            ],

            [
                'exam_type_id' => null,
                'question' => 'What Means Of Payment Is Supported By BuyCard?',
                'answer' => 'Currently we support payment with Flutterwave (Card), Paystack (Card), Wallet and Bank Transfer.',
                'is_active' => true,
            ],

            [
                'exam_type_id' => null,
                'question' => 'I Forgot My Password, How Do I Recover It?',
                'answer' => 'Simply click on the Forgot Password link on the login page, enter your email, and a link to reset your password will be sent there.',
                'is_active' => true,
            ],

            [
                'exam_type_id' => null,
                'question' => 'How Can I Sign Up on BuyCard Platform?',
                'answer' => 'Visit the website and click on the Signup link on the top menu of the page.',
                'is_active' => true,
            ],

            [
                'exam_type_id' => null,
                'question' => 'Where Can I Buy Examination Scratch Card PIN Online?',
                'answer' => 'Looking for a safe and secured platform to buy your Examination Scratch Card PIN online? Simply visit our platform to get started.',
                'is_active' => true,
            ],

        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                $faq
            );
        }
    }
}
