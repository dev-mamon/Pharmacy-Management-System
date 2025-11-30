<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Medicine;

class MedicineSeeder extends Seeder
{
    public function run(): void
    {
        $medicineList = [

            // ========================
            // 1. INFECTIOUS DISEASE
            // ========================
            'Antibiotics' => [
                ['Amoxicillin 500mg', 'Amoxicillin', 'Amoxil', '500mg'],
                ['Azithromycin 500mg', 'Azithromycin', 'Zithromax', '500mg'],
                ['Ciprofloxacin 500mg', 'Ciprofloxacin', 'Ciprocin', '500mg'],
                ['Cefixime 200mg', 'Cefixime', 'Cef-3', '200mg'],
                ['Doxycycline 100mg', 'Doxycycline', 'Doxicap', '100mg'],
            ],
            'Antivirals' => [
                ['Acyclovir 400mg', 'Acyclovir', 'Zovirax', '400mg'],
                ['Oseltamivir 75mg', 'Oseltamivir', 'Tamiflu', '75mg'],
                ['Valacyclovir 500mg', 'Valacyclovir', 'Valtrex', '500mg'],
            ],
            'Antifungals' => [
                ['Fluconazole 150mg', 'Fluconazole', 'Flunil', '150mg'],
                ['Clotrimazole Cream', 'Clotrimazole', 'Canesten', '1%'],
                ['Itraconazole 100mg', 'Itraconazole', 'Itaspor', '100mg'],
            ],
            'Antiparasitics' => [
                ['Albendazole 400mg', 'Albendazole', 'Alben', '400mg'],
                ['Ivermectin 6mg', 'Ivermectin', 'Ivera', '6mg'],
            ],
            'Antimalarials' => [
                ['Hydroxychloroquine', 'Hydroxychloroquine', 'Plaquenil', '200mg'],
                ['Artemether + Lumefantrine', 'Artemether', 'Coartem', '80/480mg'],
            ],
            'Antituberculars' => [
                ['Rifampicin', 'Rifampicin', 'Rifadin', '300mg'],
                ['Isoniazid', 'Isoniazid', 'Isozid', '100mg'],
            ],

            // ========================
            // 2. PAIN & CNS
            // ========================
            'Analgesics (NSAIDs)' => [
                ['Paracetamol 500mg', 'Paracetamol', 'Napa', '500mg'],
                ['Ibuprofen 400mg', 'Ibuprofen', 'Advil', '400mg'],
                ['Diclofenac Sodium', 'Diclofenac', 'Voltaren', '50mg'],
                ['Naproxen 500mg', 'Naproxen', 'Naprosyn', '500mg'],
            ],
            'Opioid Analgesics' => [
                ['Tramadol 50mg', 'Tramadol', 'Ultram', '50mg'],
                ['Morphine Sulfate', 'Morphine', 'Morphine', '10mg'],
            ],
            'Muscle Relaxants' => [
                ['Baclofen 10mg', 'Baclofen', 'Lioresal', '10mg'],
                ['Tizanidine 2mg', 'Tizanidine', 'Zanaflex', '2mg'],
            ],
            'Anesthetics (Local)' => [
                ['Lidocaine Gel', 'Lidocaine', 'Xylocaine', '2%'],
                ['Bupivacaine', 'Bupivacaine', 'Marcaine', '0.5%'],
            ],
            'Migraine Medications' => [
                ['Sumatriptan 50mg', 'Sumatriptan', 'Imitrex', '50mg'],
                ['Rizatriptan', 'Rizatriptan', 'Maxalt', '10mg'],
            ],
            'Anticonvulsants' => [
                ['Gabapentin 300mg', 'Gabapentin', 'Neurontin', '300mg'],
                ['Pregabalin 75mg', 'Pregabalin', 'Lyrica', '75mg'],
                ['Carbamazepine', 'Carbamazepine', 'Tegretol', '200mg'],
            ],
            'Antidepressants' => [
                ['Sertraline 50mg', 'Sertraline', 'Zoloft', '50mg'],
                ['Fluoxetine 20mg', 'Fluoxetine', 'Prozac', '20mg'],
                ['Escitalopram', 'Escitalopram', 'Lexapro', '10mg'],
            ],
            'Antipsychotics' => [
                ['Olanzapine 5mg', 'Olanzapine', 'Zyprexa', '5mg'],
                ['Risperidone 2mg', 'Risperidone', 'Risperdal', '2mg'],
            ],
            'Anxiolytics' => [
                ['Clonazepam 0.5mg', 'Clonazepam', 'Rivotril', '0.5mg'],
                ['Alprazolam 0.25mg', 'Alprazolam', 'Xanax', '0.25mg'],
            ],
            'Sedatives' => [
                ['Zolpidem 10mg', 'Zolpidem', 'Ambien', '10mg'],
                ['Midazolam', 'Midazolam', 'Dormicum', '7.5mg'],
            ],
            'Antiparkinsonian' => [
                ['Levodopa + Carbidopa', 'Levodopa', 'Sinemet', '250/25mg'],
            ],

            // ========================
            // 3. CARDIOVASCULAR
            // ========================
            'Antihypertensives' => [
                ['Losartan 50mg', 'Losartan Potassium', 'Cozaar', '50mg'],
                ['Amlodipine 5mg', 'Amlodipine', 'Norvasc', '5mg'],
                ['Bisoprolol 2.5mg', 'Bisoprolol', 'Concor', '2.5mg'],
            ],
            'Diuretics' => [
                ['Furosemide 40mg', 'Furosemide', 'Lasix', '40mg'],
                ['Spironolactone', 'Spironolactone', 'Aldactone', '25mg'],
            ],
            'Antianginals' => [
                ['Nitroglycerin', 'Nitroglycerin', 'Nitrostat', '0.5mg'],
                ['Isosorbide Mononitrate', 'Isosorbide', 'Imdur', '30mg'],
            ],
            'Antiarrhythmics' => [
                ['Amiodarone', 'Amiodarone', 'Cordarone', '200mg'],
            ],
            'Anticoagulants' => [
                ['Warfarin 5mg', 'Warfarin', 'Coumadin', '5mg'],
                ['Rivaroxaban', 'Rivaroxaban', 'Xarelto', '10mg'],
            ],
            'Antiplatelets' => [
                ['Clopidogrel 75mg', 'Clopidogrel', 'Plavix', '75mg'],
                ['Aspirin 75mg', 'Aspirin', 'Ecosprin', '75mg'],
            ],
            'Lipid-Lowering' => [
                ['Atorvastatin 10mg', 'Atorvastatin', 'Lipitor', '10mg'],
                ['Rosuvastatin 10mg', 'Rosuvastatin', 'Crestor', '10mg'],
            ],

            // ========================
            // 4. RESPIRATORY
            // ========================
            'Bronchodilators' => [
                ['Salbutamol Inhaler', 'Salbutamol', 'Ventolin', '100mcg'],
                ['Ipratropium', 'Ipratropium', 'Atrovent', '20mcg'],
            ],
            'Antihistamines' => [
                ['Cetirizine 10mg', 'Cetirizine', 'Zyrtec', '10mg'],
                ['Fexofenadine 120mg', 'Fexofenadine', 'Allegra', '120mg'],
                ['Loratadine', 'Loratadine', 'Claritin', '10mg'],
            ],
            'Cough Suppressants' => [
                ['Dextromethorphan', 'Dextromethorphan', 'Robitussin', '10mg/5ml'],
                ['Butamirate Citrate', 'Butamirate', 'Mirakof', '50mg'],
            ],
            'Nasal Decongestants' => [
                ['Xylometazoline', 'Xylometazoline', 'Otrivin', '0.1%'],
            ],

            // ========================
            // 5. GASTROINTESTINAL
            // ========================
            'Antacids & PPIs' => [
                ['Omeprazole 20mg', 'Omeprazole', 'Losec', '20mg'],
                ['Pantoprazole 40mg', 'Pantoprazole', 'Pantonic', '40mg'],
                ['Esomeprazole 20mg', 'Esomeprazole', 'Nexium', '20mg'],
            ],
            'Antiemetics' => [
                ['Ondansetron 4mg', 'Ondansetron', 'Zofran', '4mg'],
                ['Domperidone 10mg', 'Domperidone', 'Motilium', '10mg'],
            ],
            'Laxatives' => [
                ['Lactulose', 'Lactulose', 'Avilac', '100ml'],
                ['Bisacodyl', 'Bisacodyl', 'Dulcolax', '5mg'],
            ],
            'Antidiarrheals' => [
                ['Loperamide 2mg', 'Loperamide', 'Imodium', '2mg'],
            ],
            'Antispasmodics' => [
                ['Mebeverine 135mg', 'Mebeverine', 'Duspatalin', '135mg'],
                ['Hyoscine Butylbromide', 'Hyoscine', 'Buscopan', '10mg'],
            ],

            // ========================
            // 6. ENDOCRINE
            // ========================
            'Antidiabetics (Oral)' => [
                ['Metformin 500mg', 'Metformin', 'Glucophage', '500mg'],
                ['Gliclazide 80mg', 'Gliclazide', 'Diamicron', '80mg'],
                ['Sitagliptin', 'Sitagliptin', 'Januvia', '100mg'],
            ],
            'Insulin' => [
                ['Insulin Glargine', 'Insulin Glargine', 'Lantus', '100IU/ml'],
                ['Insulin Aspart', 'Insulin Aspart', 'NovoRapid', '100IU/ml'],
            ],
            'Thyroid Preparations' => [
                ['Levothyroxine 50mcg', 'Levothyroxine', 'Thyrox', '50mcg'],
                ['Carbimazole', 'Carbimazole', 'Neo-Mercazole', '5mg'],
            ],
            'Corticosteroids' => [
                ['Prednisolone 5mg', 'Prednisolone', 'Deltacortril', '5mg'],
                ['Dexamethasone 0.5mg', 'Dexamethasone', 'Oradexon', '0.5mg'],
            ],
            'Contraceptives' => [
                ['Desogestrel + Ethinylestradiol', 'Desogestrel', 'Marvelon', 'Tablet'],
                ['Levonorgestrel', 'Levonorgestrel', 'Postinor', '1.5mg'],
            ],

            // ========================
            // 7. OTHER SPECIALTIES
            // ========================
            'Vitamins & Minerals' => [
                ['Vitamin C 500mg', 'Ascorbic Acid', 'Ceevit', '500mg'],
                ['Vitamin D3 2000IU', 'Cholecalciferol', 'D-Rise', '2000IU'],
                ['B-Complex', 'Vitamin B Complex', 'Neurobion', 'Tablet'],
                ['Calcium + D3', 'Calcium Carbonate', 'Calbo-D', '500mg'],
            ],
            'Hematinics' => [
                ['Ferrous Sulfate', 'Ferrous Sulfate', 'Feofol', '150mg'],
                ['Folic Acid 5mg', 'Folic Acid', 'Folison', '5mg'],
            ],
            'Immunosuppressants' => [
                ['Cyclosporine', 'Cyclosporine', 'Sandimmune', '100mg'],
                ['Tacrolimus', 'Tacrolimus', 'Prograf', '1mg'],
            ],
            'Antineoplastics' => [
                ['Methotrexate 2.5mg', 'Methotrexate', 'Trexall', '2.5mg'],
            ],
            'Dermatologicals' => [
                ['Betamethasone Cream', 'Betamethasone', 'Betnovate', '0.1%'],
                ['Isotretinoin 10mg', 'Isotretinoin', 'Accutane', '10mg'],
            ],
            'Ophthalmic (Eye)' => [
                ['Moxifloxacin Eye Drop', 'Moxifloxacin', 'Vigamox', '0.5%'],
                ['Timolol Eye Drop', 'Timolol', 'Timoptol', '0.5%'],
            ],
            'Otic (Ear)' => [
                ['Ciprofloxacin Ear Drop', 'Ciprofloxacin', 'Ciprodex', '0.3%'],
            ],
            'Urological' => [
                ['Tamsulosin', 'Tamsulosin', 'Flomax', '0.4mg'],
                ['Sildenafil 50mg', 'Sildenafil', 'Viagra', '50mg'],
            ],
            'Anti-Gout' => [
                ['Allopurinol 100mg', 'Allopurinol', 'Zyloric', '100mg'],
                ['Febuxostat 40mg', 'Febuxostat', 'Feburic', '40mg'],
            ],
            'Osteoporosis' => [
                ['Alendronate 70mg', 'Alendronate', 'Fosamax', '70mg'],
            ],
            'Vaccines' => [
                ['Tetanus Toxoid', 'Tetanus Vaccine', 'Vaxitet', '0.5ml'],
                ['Hepatitis B', 'Hep B Vaccine', 'Engerix-B', '1ml'],
            ],
            'Antidotes' => [
                ['Naloxone', 'Naloxone', 'Narcan', '0.4mg/ml'],
                ['Atropine', 'Atropine', 'Atropine Sulfate', '0.6mg'],
            ],
        ];

        // ===========================================
        //  AUTO INSERT INTO DATABASE
        // ===========================================
        foreach ($medicineList as $categoryName => $medicineArray) {

            // Ensure the category exists (or create it if you prefer)
            $category = Category::firstOrCreate(['name' => $categoryName], [
                'name' => $categoryName,
                'description' => $categoryName . ' Category',
                'is_active' => true
            ]);

            foreach ($medicineArray as $data) {
                Medicine::create([
                    'name' => $data[0],
                    'generic_name' => $data[1],
                    'brand_name' => $data[2],
                    'strength' => $data[3],
                    'category_id' => $category->id,
                    'description' => "Used for treatment involving " . $data[1],
                    'side_effects' => 'Consult doctor for side effects.',
                    'manufacturer' => 'Global Pharma Ltd.',
                    'requires_prescription' => true,
                    'is_active' => true,
                ]);
            }
        }
    }
}
