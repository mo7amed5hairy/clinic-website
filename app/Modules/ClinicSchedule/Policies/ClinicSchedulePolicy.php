<?php

namespace App\Modules\ClinicSchedule\Policies;

use App\Models\User;
use App\Modules\ClinicSchedule\Models\ClinicSchedule;

class ClinicSchedulePolicy
{
    /**
     * تحديد إذا كان المستخدم يمكنه مشاهدة جميع الجداول
     */
    public function viewAny(User $user): bool
    {
        // اضبط الصلاحية حسب رول المستخدم
        return $user->hasPermission('clinic_schedules.view');
    }

    /**
     * تحديد إذا كان المستخدم يمكنه مشاهدة جدول محدد
     */
    public function view(User $user, ClinicSchedule $schedule): bool
    {
        return $user->hasPermission('clinic_schedules.view');
    }

    /**
     * تحديد إذا كان المستخدم يمكنه إنشاء جدول
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('clinic_schedules.create');
    }

    /**
     * تحديد إذا كان المستخدم يمكنه تحديث جدول
     */
    public function update(User $user, ClinicSchedule $schedule): bool
    {
        return $user->hasPermission('clinic_schedules.update');
    }

    /**
     * تحديد إذا كان المستخدم يمكنه حذف جدول
     */
    public function delete(User $user, ClinicSchedule $schedule): bool
    {
        return $user->hasPermission('clinic_schedules.delete');
    }
}
