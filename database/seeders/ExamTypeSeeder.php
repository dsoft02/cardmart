<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\ExamType;

class ExamTypeSeeder extends Seeder
{
    public function run()
    {
        $examTypes = [

            [
                'name' => 'WAEC Scratch Card',
                'slug' => 'waec-scratch-card',
                'price' => 3500,
                'stock_count' => 0,
                'logo' => 'https://www.buycard.ng/uploads/scratch-card/IvHxrj5QE67awyk2n1W2IMcM9-7_WvMG.png',
                'cover' => 'https://www.buycard.ng/uploads/scratch-card/oI4g0Pw6WeLlZE3xh2awmcx76DZ8sA8D.jpg',
                'pin_bg' => 'https://www.buycard.ng/uploads/scratch-card/e7b7CTjOnmAUG7OqOJaDG-EHCud1z_7s.png',
                'result_page_url' => 'https://www.waecdirect.org/',
                'about_content' => '<div>
                    <p>The WAEC Scratch Card is a product of The West African Examinations Council (WAEC). It is used to check results for candidates that sat for the WASSCE May/June and the GCE private examination.</p>
                    <p>The card contains a PIN and Serial number which can only be used 5 times to check a single candidate result.</p>
                    </div>',
                'how_to_buy_content' => '<div>
                    <p>Follow the steps below to purchase WAEC Result Checker Scratch Card:</p>
                    <ol>
                    <li>Register or Login to your account</li>
                    <li>Select quantity</li>
                    <li>Click Buy Now</li>
                    <li>Confirm your order</li>
                    <li>Proceed to payment</li>
                    <li>Complete payment and card is delivered instantly</li>
                    </ol>
                    </div>',
                'how_to_check_content' => '<div>
                    <p>Check your WAEC result by following the steps below:</p>
                    <ol>
                    <li>Visit <a href="https://www.waecdirect.org" target="_blank">www.waecdirect.org</a></li>
                    <li>Enter your Examination Number</li>
                    <li>Select Exam Year</li>
                    <li>Enter PIN and Serial Number</li>
                    <li>Click Submit</li>
                    </ol>
                    </div>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'NECO Result Token',
                'slug' => 'neco-result-token',
                'price' => 1500,
                'stock_count' => 0,
                'logo' => 'https://www.buycard.ng/uploads/scratch-card/neco-logo.png',
                'cover' => 'https://www.buycard.ng/uploads/scratch-card/neco-result-checker.jpg',
                'pin_bg' => 'https://www.buycard.ng/uploads/scratch-card/neco-bg.png',
                'result_page_url' => 'https://results.neco.gov.ng/',
                'about_content' => '<div>
                    <p>The NECO Scratch Card is a product of National Examinations Council (NECO).</p>
                    <p>Used to check results of candidates who sat for NECO SSCE exams.</p>
                    <p>The card contains a PIN and Serial number usable 5 times.</p>
                    </div>',
                'how_to_buy_content' => '<div>
                    <ol>
                    <li>Register/Login</li>
                    <li>Select NECO Result Token</li>
                    <li>Select quantity</li>
                    <li>Click Buy Now</li>
                    <li>Make payment</li>
                    <li>Receive token instantly</li>
                    </ol>
                    </div>',
                'how_to_check_content' => '<div>
                    <ol>
                    <li>Visit <a href="https://results.neco.gov.ng" target="_blank">results.neco.gov.ng</a></li>
                    <li>Select exam details</li>
                    <li>Enter TOKEN/PIN & Registration No</li>
                    <li>Click Check Result</li>
                    </ol>
                    </div>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'NABTEB Scratch Card',
                'slug' => 'nabteb-scratch-card',
                'price' => 2000,
                'stock_count' => 0,
                'logo' => 'https://www.buycard.ng/uploads/scratch-card/nabteb-logo.png',
                'cover' => 'https://www.buycard.ng/uploads/scratch-card/nabteb-result-checker.jpg',
                'pin_bg' => 'https://www.buycard.ng/uploads/scratch-card/nabteb-bg.png',
                'result_page_url' => 'https://eworld.nabteb.gov.ng/',
                'about_content' => '<div>
                    <p>The NABTEB Scratch Card is a product of National Business and Technical Education Board (NABTEB).</p>
                    <p>Used to check NABTEB examination results.</p>
                    <p>PIN and Serial usable 5 times.</p>
                    </div>',
                'how_to_buy_content' => '<div>
                    <ol>
                    <li>Register/Login</li>
                    <li>Select NABTEB Scratch Card</li>
                    <li>Select quantity</li>
                    <li>Click Buy Now</li>
                    <li>Make payment</li>
                    <li>Receive PIN instantly</li>
                    </ol>
                    </div>',
                'how_to_check_content' => '<div>
                    <ol>
                    <li>Visit <a href="https://eworld.nabteb.gov.ng/" target="_blank">eworld.nabteb.gov.ng</a></li>
                    <li>Enter candidate details</li>
                    <li>Enter PIN & Serial</li>
                    <li>Click Submit</li>
                    </ol>
                    </div>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'WAEC Verification Pin (NYSC)',
                'slug' => 'waec-verification-pin-nysc',
                'price' => 5000,
                'stock_count' => 0,
                'logo' => 'https://www.buycard.ng/uploads/scratch-card/_5dR3he4u5JQChPdkHTY4u0liMJWyzcq.png',
                'cover' => 'https://www.buycard.ng/uploads/scratch-card/Nu2BKFqhFyYgNvOTTZWOwwqVIhj5UJSI.jpg',
                'pin_bg' => 'https://www.buycard.ng/uploads/scratch-card/e7b7CTjOnmAUG7OqOJaDG-EHCud1z_7s.png',
                'result_page_url' => 'https://portal.nysc.org.ng/nysc1/',
                'about_content' => '<div>
                    <p>The WAEC Verification pin is used by institutions and NYSC to verify candidate information.</p>
                    <p>This PIN allows verification of date of birth, grades and records.</p>
                    </div>',
                'how_to_buy_content' => '<div>
                    <ol>
                    <li>Register/Login</li>
                    <li>Select WAEC Verification PIN</li>
                    <li>Select quantity</li>
                    <li>Buy Now</li>
                    <li>Make payment</li>
                    <li>Receive PIN instantly</li>
                    </ol>
                    </div>',
                'how_to_check_content' => '<div>
                    <ol>
                    <li>Visit <a href="https://portal.nysc.org.ng/nysc1/" target="_blank">NYSC Portal</a></li>
                    <li>Login</li>
                    <li>Click Change Date of Birth</li>
                    <li>Enter PIN</li>
                    <li>Submit</li>
                    </ol>
                    <p><b>NOTE:</b> This PIN is usable once.</p>
                    </div>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($examTypes as $exam) {

            // Download images
            $coverExtension = pathinfo($exam['cover'], PATHINFO_EXTENSION);
            $logoExtension = pathinfo($exam['logo'], PATHINFO_EXTENSION);
            $bgExtension = pathinfo($exam['pin_bg'], PATHINFO_EXTENSION);

            $coverFileName = Str::slug($exam['slug']) . '-cover.' . $coverExtension;
            $logoFileName = Str::slug($exam['slug']) . '-logo.' . $logoExtension;
            $bgFileName = Str::slug($exam['slug']) . '-bg.' . $logoExtension;

            $coverPath = 'exam-types/covers/' . $coverFileName;
            $logoPath = 'exam-types/logos/' . $logoFileName;
            $bgPath = 'exam-types/pinbg/' . $logoFileName;

            if (!Storage::disk('public')->exists($coverPath)) {
                Storage::disk('public')->put($coverPath, file_get_contents($exam['cover']));
            }

            if (!Storage::disk('public')->exists($logoPath)) {
                Storage::disk('public')->put($logoPath, file_get_contents($exam['logo']));
            }

            if (!Storage::disk('public')->exists($bgPath)) {
                Storage::disk('public')->put($bgPath, file_get_contents($exam['pin_bg']));
            }

            ExamType::updateOrCreate(
                ['slug' => $exam['slug']],
                [
                    'name' => $exam['name'],
                    'price' => $exam['price'],
                    'stock_count' => $exam['stock_count'],
                    'logo' => $logoPath,
                    'cover_image' => $coverPath,
                    'pin_background_image' => $bgPath,
                    'result_page_url' => $exam['result_page_url'],
                    'about_content' => $exam['about_content'],
                    'how_to_buy_content' => $exam['how_to_buy_content'],
                    'how_to_check_content' => $exam['how_to_check_content'],
                    'is_active' => true,
                ]
            );
        }
    }
}
