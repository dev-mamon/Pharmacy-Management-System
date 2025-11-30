<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    public function run(): void
{
    $categories = [
        ['name' => 'Antibiotics', 'description' => 'Medicines used to treat bacterial infections'],
        ['name' => 'Antivirals', 'description' => 'Medicines used to treat viral infections'],
        ['name' => 'Antifungals', 'description' => 'Medicines used to treat fungal infections'],
        ['name' => 'Antiparasitics', 'description' => 'Medicines used to treat parasitic infections'],

        ['name' => 'Analgesics', 'description' => 'Pain relief medicines'],
        ['name' => 'Antipyretics', 'description' => 'Medicines used to reduce fever'],
        ['name' => 'NSAIDs', 'description' => 'Non-steroidal anti-inflammatory drugs'],
        ['name' => 'Opioids', 'description' => 'Strong pain relief medicines'],

        ['name' => 'Antacids', 'description' => 'Medicines for acidity and reflux'],
        ['name' => 'Gastrointestinal', 'description' => 'Digestive system related medicines'],

        ['name' => 'Vitamins', 'description' => 'Vitamin supplements'],
        ['name' => 'Minerals', 'description' => 'Mineral supplements'],
        ['name' => 'Multivitamins', 'description' => 'Combined vitamin and mineral supplements'],

        ['name' => 'Cardiac', 'description' => 'Heart and blood pressure medicines'],
        ['name' => 'Antihypertensives', 'description' => 'Medicines to reduce blood pressure'],
        ['name' => 'Anticoagulants', 'description' => 'Blood thinners'],
        ['name' => 'Antiarrhythmics', 'description' => 'Medicines for irregular heartbeats'],

        ['name' => 'Diabetic', 'description' => 'Diabetes management medicines'],
        ['name' => 'Insulin', 'description' => 'Insulin therapy medicines'],

        ['name' => 'Respiratory', 'description' => 'Asthma and lung-related medicines'],
        ['name' => 'Antihistamines', 'description' => 'Allergy relief medicines'],
        ['name' => 'Cough and Cold', 'description' => 'Medicines for cough and cold'],

        ['name' => 'Dermatological', 'description' => 'Skin care and dermatology medicines'],

        ['name' => 'Antiseptics', 'description' => 'Wound care and disinfectants'],
        ['name' => 'Disinfectants', 'description' => 'Surface and skin disinfecting agents'],

        ['name' => 'Eye Medicines', 'description' => 'Ophthalmic medicines'],
        ['name' => 'Ear Medicines', 'description' => 'Otic medicines'],
        ['name' => 'Nasal Medicines', 'description' => 'Nasal sprays and solutions'],

        ['name' => 'Hormonal', 'description' => 'Hormone-related medicines'],
        ['name' => 'Steroids', 'description' => 'Corticosteroids and anabolic steroids'],
        ['name' => 'Contraceptives', 'description' => 'Birth control medicines'],

        ['name' => 'Psychiatric', 'description' => 'Mental health medicines'],
        ['name' => 'Antidepressants', 'description' => 'Medicines for depression'],
        ['name' => 'Antipsychotics', 'description' => 'Medicines for psychosis'],
        ['name' => 'Anxiolytics', 'description' => 'Anti-anxiety medicines'],
        ['name' => 'Sedatives', 'description' => 'Sleep and calming medicines'],

        ['name' => 'Oncology', 'description' => 'Cancer treatment medicines'],
        ['name' => 'Immunosuppressants', 'description' => 'Medicines that suppress immune response'],

        ['name' => 'Neurological', 'description' => 'Brain and nerve medicines'],
        ['name' => 'Anticonvulsants', 'description' => 'Medicines for seizures'],
        ['name' => 'Parkinsons Medicines', 'description' => 'Medicines for Parkinson\'s disease'],

        ['name' => 'Musculoskeletal', 'description' => 'Bone and muscle related medicines'],
        ['name' => 'Osteoporosis Medicines', 'description' => 'Bone density improving medicines'],

        ['name' => 'Rehabilitation', 'description' => 'Therapeutic and supportive care medicines'],

        ['name' => 'IV Fluids', 'description' => 'Intravenous fluids and electrolytes'],
        ['name' => 'Vaccines', 'description' => 'Preventive vaccines'],
    ];

    foreach ($categories as $category) {
        Category::create($category);
    }
}

}
