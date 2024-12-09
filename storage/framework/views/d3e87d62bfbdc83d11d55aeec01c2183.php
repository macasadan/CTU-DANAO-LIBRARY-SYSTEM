<?php $__env->startSection('content'); ?>
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-red-600 via-orange-500 to-blue-600 bg-clip-text text-transparent">
                Discussion Rooms
            </h1>
            <p class="mt-2 text-gray-600">Manage your discussion room reservations</p>
        </div>

        <!-- Action Button -->
        <div class="mb-6">
            <a href="<?php echo e(route('reservations.create')); ?>"
                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-600 to-orange-500 hover:from-red-700 hover:to-orange-600 text-white font-semibold rounded-lg shadow-sm transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Reservation
            </a>
        </div>

        <!-- Available Rooms -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Discussion Rooms</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border rounded-lg p-4 relative">
                        <!-- Room Header -->
                        <div class="flex justify-between items-start">
                            <h3 class="font-semibold text-lg"><?php echo e($room->name); ?></h3>
                            <span class="px-3 py-1 rounded-full text-xs font-medium 
    <?php echo e($room->availability_status === 'occupied' ? 'bg-red-100 text-red-800' : 
       ($room->availability_status === 'reserved' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800')); ?>">
    <?php echo e(ucfirst($room->availability_status)); ?>

</span>
                        </div>

                        <div class="mt-2 text-sm text-gray-600">
                            Capacity: <?php echo e($room->capacity); ?> people
                        </div>

                        <!-- Current Reservation Info -->
                        <?php if($room->current_reservation): ?>
                        <div class="mt-4 p-3 bg-gray-50 rounded-md">
                            <div class="text-sm">
                                <p class="font-medium text-gray-700">Current Session:</p>
                                <div class="mt-1 space-y-1">
                                    <p>Reserved by: <?php echo e($room->current_reservation->user->name); ?></p>
                                    <p>Until: <?php echo e($room->current_reservation->end_time->format('h:i A')); ?></p>
                                    <p class="text-xs text-gray-500">Purpose: <?php echo e($room->current_reservation->purpose); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Upcoming Reservations -->
                        <?php if($room->upcoming_reservations->isNotEmpty()): ?>
                        <div class="mt-4">
                            <p class="text-sm font-medium text-gray-700">Upcoming Today:</p>
                            <div class="mt-2 space-y-2">
                                <?php $__currentLoopData = $room->upcoming_reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="text-xs bg-gray-50 p-2 rounded">
                                    <p><?php echo e($reservation->start_time->format('h:i A')); ?> - 
                                       <?php echo e($reservation->end_time->format('h:i A')); ?></p>
                                    <p class="text-gray-500"><?php echo e($reservation->user->name); ?></p>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        <!-- Your Active Reservations List -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Your Active Reservations</h2>

                <?php if($userReservations->count() > 0): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php $__currentLoopData = $userReservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo e($reservation->discussionRoom->name); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <?php echo e($reservation->start_time->format('M d, Y h:i A')); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <?php echo e($reservation->end_time->format('M d, Y h:i A')); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium
                                        <?php if($reservation->status === 'approved'): ?> bg-green-100 text-green-800
                                        <?php elseif($reservation->status === 'rejected'): ?> bg-red-100 text-red-800
                                        <?php else: ?> bg-yellow-100 text-yellow-800
                                        <?php endif; ?>">
                                        <?php echo e(ucfirst($reservation->status)); ?>

                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No active reservations</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new reservation.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\git\Final-Library-System-Capstone-1\final-1\resources\views/reservations/index.blade.php ENDPATH**/ ?>