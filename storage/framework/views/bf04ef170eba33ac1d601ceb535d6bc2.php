

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">All Borrowed Books and Students</h2>
        <div class="flex space-x-4">
            <form class="flex space-x-2" action="<?php echo e(route('admin.borrows.borrowed')); ?>" method="GET">
                <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                    <option value="">All Status</option>
                    <option value="approved" <?php echo e(request('status') === 'approved' ? 'selected' : ''); ?>>Currently Borrowed</option>
                    <option value="returned" <?php echo e(request('status') === 'returned' ? 'selected' : ''); ?>>Returned</option>
                </select>
                <input type="text"
                    name="search"
                    value="<?php echo e(request('search')); ?>"
                    placeholder="Search by title or student name"
                    class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    Search
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book & Student</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Borrow Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Return Date</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $allBorrows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $borrow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900"><?php echo e($borrow->book->title); ?></div>
                        <div class="text-sm text-gray-500">
                            Student: <?php echo e($borrow->user->name); ?> (<?php echo e($borrow->id_number); ?>)
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            <?php echo e($borrow->returned_at 
                                ? 'bg-gray-100 text-gray-800'
                                : 'bg-green-100 text-green-800'); ?>">
                            <?php echo e($borrow->returned_at ? 'Returned' : 'Currently Borrowed'); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <?php echo e($borrow->borrow_date ? $borrow->borrow_date->format('M d, Y') : '-'); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <?php echo e($borrow->due_date ? $borrow->due_date->format('M d, Y') : '-'); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <?php echo e($borrow->returned_at ? $borrow->returned_at->format('M d, Y') : '-'); ?>

                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        No borrowed books found.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="px-6 py-4">
            <?php echo e($allBorrows->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Handle status filter changes
    document.getElementById('statusFilter').addEventListener('change', function() {
        const currentUrl = new URL(window.location.href);
        currentUrl.searchParams.set('status', this.value);
        window.location.href = currentUrl.toString();
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\LARAVEL\tatan\CTU-DANAO-LIBRARY-SYSTEM\resources\views/admin/borrows/borrowed.blade.php ENDPATH**/ ?>