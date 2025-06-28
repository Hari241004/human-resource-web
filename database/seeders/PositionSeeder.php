<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Position;
use App\Models\Department;

class PositionSeeder extends Seeder
{
    public function run()
    {
        // Mapping department name => positions
        $mapping = [
            'IT' => [
                'Frontend Developer',
                'Backend Developer',
                'Full Stack Developer',
                'UI/UX Designer',
                'System Administrator',
                'DevOps Engineer',
                'IT Support',
            ],
            'Human Resources' => [
                'HR Manager',
                'Recruiter',
                'HR Officer',
                'Training Specialist',
            ],
            'Finance' => [
                'Finance Manager',
                'Accountant',
                'Payroll Officer',
                'Internal Auditor',
            ],
            'Marketing' => [
                'Marketing Manager',
                'Content Creator',
                'Social Media Specialist',
                'SEO Specialist',
                'Brand Strategist',
            ],
            'Sales' => [
                'Sales Manager',
                'Sales Executive',
                'Account Manager',
                'Sales Analyst',
            ],
            'Operations' => [
                'Operations Manager',
                'Warehouse Supervisor',
                'Logistics Coordinator',
                'Quality Control Officer',
            ],
            'Legal' => [
                'Legal Counsel',
                'Compliance Officer',
                'Legal Assistant',
            ],
            'Customer Service' => [
                'Customer Service Manager',
                'Customer Support Agent',
                'Helpdesk Officer',
            ],
            'Procurement' => [
                'Procurement Manager',
                'Purchasing Staff',
                'Inventory Analyst',
            ],
            'R&D' => [
                'R&D Manager',
                'Product Developer',
                'Innovation Analyst',
            ],
        ];

        foreach ($mapping as $deptName => $positions) {
            // cari department, skip jika belum ada
            $dept = Department::firstWhere('name', $deptName);
            if (! $dept) {
                $this->command->warn("Department '{$deptName}' belum ada, lewati posisi.");
                continue;
            }

            foreach ($positions as $posName) {
                Position::firstOrCreate([
                    'name'          => $posName,
                    'department_id' => $dept->id,
                ]);
            }
        }
    }
}
