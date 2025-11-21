<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EmailListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $emails = [
            'ambrosenjeru@gmail.com',
            'anjeru@tripleoklaw.com',
            'akadzo@tripleoklaw.com',
            'wacekeannie@citibus.co.ke',
            'ndiranguann93@yahoo.com',
            'kitongas325@gmail.com',
            'bngunzi@ngunziandassociates.co.ke',
            'bethu69@gmail.com',
            'clarajaluha41@gmail.com',
            'charlesnjagi@yahoo.com',
            'echelagat@tripleoklaw.com',
            'consolatawanjirukariuki@gmail.com',
            'cnyaruiru@gmail.com',
            'cecil_kuyo@yahoo.com',
            'adalodaniel28@gmail.com',
            'dlumwaji@tripleoklaw.com',
            'jdondi@tripleoklaw.com',
            'estherkitonga7013@gmail.com',
            'emureithi@tripleoklaw.com',
            'eodhiambo@tripleoklaw.com',
            'e_murua@yahoo.com',
            'fmunyao@tripleoklaw.com',
            'fwandera@tripleoklaw.com',
            'gacherujane2016@gmail.com',
            'gatheruwangui230@gmail.com',
            'gachukiawanyoike@gmail.com',
            'ikiche@tripleoklaw.com',
            'jkabue@tripleoklaw.com',
            'jim.manyonge@gmail.com',
            'jochieng@tripleoklaw.com',
            'kamathuku@gmail.com',
            'jenipher.musambai@gmail.com',
            'tonyango@tripleoklaw.com',
            'jkibet@tripleoklaw.com',
            'jnjeri@tripleoklaw.com',
            'jmbeya@tripleoklaw.com',
            'kimtuku@gmail.com',
            'kibanyakamaulaw@gmail.com',
            'pkihato@tripleoklaw.com',
            'lndungu@nnkadvocates.co.ke',
            'lmwangangi@tripleoklaw.com',
            'marysheila@tripleoklaw.com',
            'ymukua@gmail.com',
            'modhiambo@tripleoklaw.com',
            'mwaura_rachel@yahoo.com',
            'morris.oduor@gmail.com',
            'mercynjokiguku@yahoo.com',
            'maggretaz@gmail.com',
            'mnduku@tripleoklaw.com',
            'nicmachar@gmail.com',
            'rose.knjoki@gmail.com',
            'nwetunga@gmail.com',
            'wojore@tripleoklaw.com',
            'paulinejk@gmail.com',
            'ruthmaina82@yahoo.com',
            'rosekiama911@gmail.com',
            'simonmusembeisyengo@gmail.com',
            'syengolito@gmail.com',
            'winisimz@gmail.com',
            'wmuiggz2014@gmail.com',
            'mwambua@tripleoklaw.com',
            'munuthiwanjiku@gmail.com',
            'wacekeannie@gmail.com',
            'duncanmuchani779@gmail.com',
            'mmngunzi@yahoo.com',
            'winnerangelica@gmail.com',
            'kimanthimwabuli@gmail.com',
        ];

        $created = 0;
        $skipped = 0;

        foreach ($emails as $email) {
            // Check if user already exists
            if (User::where('email', $email)->exists()) {
                $skipped++;
                continue;
            }

            // Extract name from email
            $name = $this->extractNameFromEmail($email);

            // Create user
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('password'), // Default password
                'role' => 'member', // Default role
            ]);

            $created++;
        }

        $this->command->info("Created {$created} users. Skipped {$skipped} existing users.");
    }

    /**
     * Extract a readable name from email address
     */
    private function extractNameFromEmail(string $email): string
    {
        // Get the part before @
        $localPart = explode('@', $email)[0];
        
        // Remove numbers and special characters
        $name = preg_replace('/[0-9_]+/', ' ', $localPart);
        
        // Replace dots, underscores, and hyphens with spaces
        $name = str_replace(['.', '_', '-'], ' ', $name);
        
        // Capitalize words
        $name = ucwords(strtolower(trim($name)));
        
        // If name is too short or empty, use a default
        if (strlen($name) < 3) {
            $name = 'User ' . Str::random(4);
        }
        
        return $name;
    }
}
