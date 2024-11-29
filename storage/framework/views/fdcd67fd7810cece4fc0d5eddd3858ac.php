

<?php $__env->startSection('title', 'Super Admin Dashboard'); ?>

<?php $__env->startSection('header', 'Dashboard Overview'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Total Users</h2>
            <p class="text-3xl font-bold text-blue-600"><?php echo e($totalUsers); ?></p>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Total Books</h2>
            <p class="text-3xl font-bold text-green-600"><?php echo e($totalBooks); ?></p>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Discussion Rooms</h2>
            <p class="text-3xl font-bold text-red-600"><?php echo e($totalDiscussionRooms); ?></p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Existing cards -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Total Administrators</h2>
        <p class="text-3xl font-bold text-purple-600"><?php echo e($totalAdmins); ?></p>
    </div>
</div>
    </div>

    <div class="mt-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Quick Actions</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="<?php echo e(route('super-admin.manage-admins')); ?>" 
               class="bg-indigo-500 text-white py-3 px-6 rounded-lg text-center hover:bg-indigo-600 transition">
                Manage Admins
            </a>
            <a href="<?php echo e(route('super-admin.create-admin')); ?>" 
               class="bg-green-500 text-white py-3 px-6 rounded-lg text-center hover:bg-green-600 transition">
                Create New Admin
            </a>
            <a href="<?php echo e(route('super-admin.system-logs')); ?>" 
               class="bg-red-500 text-white py-3 px-6 rounded-lg text-center hover:bg-red-600 transition">
                System Logs
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.superadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\LARAVEL\tatan\CTU-DANAO-LIBRARY-SYSTEM\resources\views/super-admin/dashboard.blade.php ENDPATH**/ ?>