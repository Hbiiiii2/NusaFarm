<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Farmland;
use App\Models\Project;
use App\Models\Investment;
use App\Models\WalletTransaction;
use App\Models\FarmingTask;
use App\Models\Logistics;
use App\Models\Notification;
use App\Models\Badge;
use Illuminate\Support\Facades\Hash;
use App\Models\DailyReport;

class NusaFarmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create users with different roles
        $users = [
            [
                'name' => 'John Investor',
                'email' => 'investor@nusafarm.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'xp' => 150,
                'level' => 2,
                'wallet_balance' => 5000000,
            ],
            [
                'name' => 'Sarah Landlord',
                'email' => 'landlord@nusafarm.com',
                'password' => Hash::make('password'),
                'role' => 'landlord',
                'xp' => 75,
                'level' => 1,
                'wallet_balance' => 10000000,
            ],
            [
                'name' => 'Budi Petani',
                'email' => 'petani@nusafarm.com',
                'password' => Hash::make('password'),
                'role' => 'petani',
                'xp' => 200,
                'level' => 3,
                'wallet_balance' => 500000,
            ],
            [
                'name' => 'Pak Manajer',
                'email' => 'manajer@nusafarm.com',
                'password' => Hash::make('password'),
                'role' => 'manajer_lapangan',
                'xp' => 300,
                'level' => 4,
                'wallet_balance' => 1000000,
            ],
            [
                'name' => 'Sari Logistik',
                'email' => 'logistik@nusafarm.com',
                'password' => Hash::make('password'),
                'role' => 'logistik',
                'xp' => 120,
                'level' => 2,
                'wallet_balance' => 750000,
            ],
            [
                'name' => 'Pak Pupuk',
                'email' => 'pupuk@nusafarm.com',
                'password' => Hash::make('password'),
                'role' => 'penyedia_pupuk',
                'xp' => 180,
                'level' => 3,
                'wallet_balance' => 2000000,
            ],
            [
                'name' => 'Ibu Pasar',
                'email' => 'pedagang@nusafarm.com',
                'password' => Hash::make('password'),
                'role' => 'pedagang_pasar',
                'xp' => 250,
                'level' => 3,
                'wallet_balance' => 1500000,
            ],
            [
                'name' => 'Admin NusaFarm',
                'email' => 'admin@nusafarm.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'xp' => 500,
                'level' => 6,
                'wallet_balance' => 5000000,
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        // Create farmlands (ready for investment)
        $admin = User::where('role', 'admin')->first();
        $landlord = User::where('role', 'landlord')->first();
        $manager = User::where('role', 'manajer_lapangan')->first();
        $petani = User::where('role', 'petani')->first();
        $investor = User::where('role', 'user')->first();

        $farmlandRecords = [
            [
                'location' => 'Kabupaten Bogor, Jawa Barat',
                'size' => 5.0,
                'crop_type' => 'Sayuran',
                'investment_period_months' => 6,
                'required_investment_amount' => 15000000,
                'minimum_investment_amount' => 1000000,
            ],
            [
                'location' => 'Kabupaten Bandung, Jawa Barat',
                'size' => 3.5,
                'crop_type' => 'Padi',
                'investment_period_months' => 9,
                'required_investment_amount' => 20000000,
                'minimum_investment_amount' => 1500000,
            ],
            [
                'location' => 'Kabupaten Sukabumi, Jawa Barat',
                'size' => 7.0,
                'crop_type' => 'Jagung',
                'investment_period_months' => 8,
                'required_investment_amount' => 25000000,
                'minimum_investment_amount' => 2000000,
            ],
        ];

        $farmlandsCreated = [];
        foreach ($farmlandRecords as $record) {
            $farmlandsCreated[] = Farmland::create([
                'landlord_id' => $landlord->id,
                'location' => $record['location'],
                'size' => $record['size'],
                'status' => 'ready_for_investment',
                'rental_price' => 5000000,
                'description' => 'Lahan siap ditanam dengan kondisi sangat baik.',
                'crop_type' => $record['crop_type'],
                'approved_by_admin_at' => now(),
                'approved_by_admin_by' => $admin->id,
                'ready_for_investment_at' => now()->subDays(3),
                'ready_for_investment_by' => $manager->id,
                'investment_period_months' => $record['investment_period_months'],
                'required_investment_amount' => $record['required_investment_amount'],
                'minimum_investment_amount' => $record['minimum_investment_amount'],
                'investment_notes' => 'Target ROI 15% per tahun, proyeksi bagus.',
            ]);
        }

        // Create projects on farmlands
        $projectsCreated = [];
        $projectTemplates = [
            ['title' => 'Proyek Sayuran Organik Bogor', 'expected_roi' => 25.00, 'months' => 6],
            ['title' => 'Proyek Padi Ramah Lingkungan Bandung', 'expected_roi' => 22.00, 'months' => 9],
            ['title' => 'Proyek Jagung Premium Sukabumi', 'expected_roi' => 18.00, 'months' => 8],
        ];
        foreach ($farmlandsCreated as $index => $farmland) {
            $tpl = $projectTemplates[$index];
            $start = now()->subMonths(1);
            $end = (clone $start)->addMonths($tpl['months']);
            $projectsCreated[] = Project::create([
                'farmland_id' => $farmland->id,
                'manager_id' => $manager->id,
                'title' => $tpl['title'],
                'description' => 'Proyek budidaya dengan praktik terbaik dan monitoring berkala.',
                'status' => 'active',
                'start_date' => $start,
                'end_date' => $end,
                'expected_roi' => $tpl['expected_roi'],
            ]);
        }

        // Assign farming tasks to petani to link them with projects
        foreach ($projectsCreated as $project) {
            FarmingTask::create([
                'project_id' => $project->id,
                'assigned_to' => $petani->id,
                'task_type' => 'planting',
                'description' => 'Penanaman awal dan persiapan lahan.',
                'status' => 'ongoing',
                'scheduled_date' => now()->addDays(7),
            ]);
        }

        // Create daily reports from petani for first two projects
        $reportProjects = array_slice($projectsCreated, 0, 2);
        foreach ($reportProjects as $project) {
            DailyReport::create([
                'user_id' => $petani->id,
                'project_id' => $project->id,
                'activity_description' => 'Pemeriksaan kelembaban tanah dan kondisi bibit. Penyiraman rutin dilakukan.',
                'photo_path' => null, // Taruh file di storage/app/public/daily-reports/photos untuk ditampilkan
                'video_path' => null, // Taruh file di storage/app/public/daily-reports/videos untuk ditampilkan
                'weather_condition' => 'cerah',
                'plant_condition' => 'Bibit tumbuh baik, daun hijau segar.',
                'pest_issues' => 'Tidak ditemukan hama.',
                'status' => 'approved',
                'manager_notes' => 'Lanjutkan pemeliharaan seperti ini.',
            ]);
        }

        // Create investments by investor into first two farmlands
        $investments = [
            [
                'user_id' => $investor->id,
                'farmland_id' => $farmlandsCreated[0]->id,
                'amount' => 5000000,
                'status' => 'confirmed',
            ],
            [
                'user_id' => $investor->id,
                'farmland_id' => $farmlandsCreated[1]->id,
                'amount' => 3000000,
                'status' => 'confirmed',
            ],
        ];
        foreach ($investments as $investmentData) {
            Investment::create($investmentData);
        }

        // Wallet transactions for investor
        WalletTransaction::create([
            'user_id' => $investor->id,
            'type' => 'topup',
            'amount' => 10000000,
            'description' => 'Initial top up wallet',
        ]);
        WalletTransaction::create([
            'user_id' => $investor->id,
            'type' => 'investment',
            'amount' => -5000000,
            'description' => 'Investment in '.$projectsCreated[0]->title,
        ]);
        WalletTransaction::create([
            'user_id' => $investor->id,
            'type' => 'investment',
            'amount' => -3000000,
            'description' => 'Investment in '.$projectsCreated[1]->title,
        ]);

        // // Create wallet transactions
        // $transactions = [
        //     [
        //         'user_id' => 1,
        //         'type' => 'topup',
        //         'amount' => 10000000,
        //         'description' => 'Top up wallet',
        //     ],
        //     [
        //         'user_id' => 1,
        //         'type' => 'investment',
        //         'amount' => -5000000,
        //         'description' => 'Investment in Proyek Sayuran Organik Bogor',
        //     ],
        //     [
        //         'user_id' => 1,
        //         'type' => 'investment',
        //         'amount' => -7500000,
        //         'description' => 'Investment in Proyek Buah Naga Bandung',
        //     ],
        // ];

        // foreach ($transactions as $transactionData) {
        //     WalletTransaction::create($transactionData);
        // }

        // // Create farming tasks (commented out - tables still use project_id)
        // // $tasks = [
        // //     [
        // //         'project_id' => 1,
        // //         'assigned_to' => 3, // Budi Petani
        // //         'task_type' => 'planting',
        // //         'description' => 'Membersihkan dan menyiapkan lahan untuk penanaman',
        // //         'status' => 'ongoing',
        // //         'scheduled_date' => now()->addDays(7),
        // //     ],
        // //     [
        // //         'project_id' => 1,
        // //         'assigned_to' => 3, // Budi Petani
        // //         'task_type' => 'planting',
        // //         'description' => 'Menanam benih sayuran organik',
        // //         'status' => 'pending',
        // //         'scheduled_date' => now()->addDays(14),
        // //     ],
        // // ];

        // // foreach ($tasks as $taskData) {
        // //     FarmingTask::create($taskData);
        // // }

        // // Create logistics (commented out - tables still use project_id)
        // // $logistics = [
        // //     [
        // //         'logistics_user_id' => 5, // Sari Logistik
        // //         'project_id' => 1,
        // //         'delivery_type' => 'Pupuk Organik',
        // //         'status' => 'delivered',
        // //         'delivery_date' => now()->subDays(5),
        // //     ],
        // //     [
        // //         'logistics_user_id' => 5, // Sari Logistik
        // //         'project_id' => 1,
        // //         'delivery_type' => 'Benih Sayuran',
        // //         'status' => 'in_transit',
        // //         'delivery_date' => now()->addDays(3),
        // //     ],
        // // ];

        // // foreach ($logistics as $logisticData) {
        // //     Logistics::create($logisticData);
        // // }

        // Create notifications
        $notifications = [
            [
                'user_id' => $investor->id,
                'title' => 'Investment Successful',
                'message' => 'Your investment in '.$projectsCreated[0]->title.' has been confirmed.',
                'is_read' => false,
            ],
            [
                'user_id' => $investor->id,
                'title' => 'New Project Available',
                'message' => 'A new project "'.$projectsCreated[1]->title.'" is now available for investment.',
                'is_read' => false,
            ],
        ];

        foreach ($notifications as $notificationData) {
            Notification::create($notificationData);
        }

        // Create badges
        $badges = [
            [
                'name' => 'First Investment',
                'description' => 'Made your first investment',
            ],
            [
                'name' => 'Active Investor',
                'description' => 'Invested in 5 projects',
            ],
            [
                'name' => 'Top Performer',
                'description' => 'Achieved 25% ROI',
            ],
        ];

        foreach ($badges as $badgeData) {
            Badge::create($badgeData);
        }
    }
} 