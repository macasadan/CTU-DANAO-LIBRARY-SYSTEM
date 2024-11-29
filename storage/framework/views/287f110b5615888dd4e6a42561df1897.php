<?php $__env->startSection('title', 'Reservation History'); ?>
<?php $__env->startSection('header', 'Reservation History'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-lg shadow-md p-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg border border-gray-200">
            <h3 class="text-gray-500 text-sm">Total Reservations</h3>
            <p class="text-2xl font-bold"><?php echo e($stats['total_reservations']); ?></p>
        </div>
        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
            <h3 class="text-gray-500 text-sm">Approved</h3>
            <p class="text-2xl font-bold text-green-600"><?php echo e($stats['approved_count']); ?></p>
        </div>
        <div class="bg-red-50 p-4 rounded-lg border border-red-200">
            <h3 class="text-gray-500 text-sm">Rejected</h3>
            <p class="text-2xl font-bold text-red-600"><?php echo e($stats['rejected_count']); ?></p>
        </div>
        <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
            <h3 class="text-gray-500 text-sm">Pending</h3>
            <p class="text-2xl font-bold text-yellow-600"><?php echo e($stats['pending_count']); ?></p>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="mb-6">
        <form action="<?php echo e(route('admin.discussion_rooms.history')); ?>" method="GET" class="flex gap-4">
            <div class="flex-1">
                <input type="text" name="search" placeholder="Search by user or room" 
                       class="w-full rounded-md border-gray-300" 
                       value="<?php echo e(request('search')); ?>">
            </div>
            <div class="flex-1">
                <select name="status" class="w-full rounded-md border-gray-300">
                    <option value="">All Statuses</option>
                    <option value="approved" <?php echo e(request('status') === 'approved' ? 'selected' : ''); ?>>Approved</option>
                    <option value="rejected" <?php echo e(request('status') === 'rejected' ? 'selected' : ''); ?>>Rejected</option>
                    <option value="pending" <?php echo e(request('status') === 'pending' ? 'selected' : ''); ?>>Pending</option>
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Filter
            </button>
        </form>
    </div>

    <!-- Reservations Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purpose</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900"><?php echo e($reservation->user->name); ?></div>
                        <div class="text-sm text-gray-500"><?php echo e($reservation->user->email); ?></div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <?php echo e($reservation->discussionRoom->name); ?>

                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        <?php echo e($reservation->purpose); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <?php echo e($reservation->start_time->format('M d, Y H:i')); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <?php echo e($reservation->end_time->format('M d, Y H:i')); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            <?php if($reservation->status === 'approved'): ?> bg-green-100 text-green-800
                            <?php elseif($reservation->status === 'rejected'): ?> bg-red-100 text-red-800
                            <?php else: ?> bg-yellow-100 text-yellow-800
                            <?php endif; ?>">
                            <?php echo e(ucfirst($reservation->status)); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <?php echo e($reservation->created_at->format('M d, Y H:i')); ?>

                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        No reservations found
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        <?php echo e($reservations->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\git\Final-Library-System-Capstone-1\final-1\resources\views/admin/discussion_rooms/history.blade.php ENDPATH**/ ?>