<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class DatabaseSeeder extends Seeder
{

    /**
     * List of applications to add.
     */
    private $permissions = [
        'الفوتير',
        'قائمة الفواتير',
        'الفوتير المدفوعة',
        'الفواتير الغير مدفوعة',
        'الفواتير المدفوعة جزئيا',
        'التقارير',
        'تقارير الفواتير',
        'المستخدمين',
        'قائمة المستخدمين',
        'صلاحيات المستخدمين',
        'الاعدادت',
        'الاقسام',
        'المنتجات',

        'إضافة فاتورة',
        'تصدير إكسيل',
        'تغير حالة الدفع',
        'حذف الفاتورة',
        'تعديل الفاتورة',
        'إضافة مرفق',
        'حذف مرفق',

        'إضافة مستخدم',
        'تعديل مستخدم',
        'حذف مستخدم',

        'عرض الصلاحيات',
        'إضافة صلاحية',
        'تعديل صلاحية',
        'حذف صلاحية',

        'إضافة منتج',
        'تعديل منتج',
        'حذف منتج',

        'إضافة قسم',
        'تعديل قسم',
        'حذف قسم',

    ];


    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create admin User and assign the role to him.
        $user = User::create([
            'name' => 'mahrous',
            'email' => 'mahroustamim@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $role = Role::create(['name' => 'owner']);

        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}