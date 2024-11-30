

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Returned Books</h1>

    <!-- Search and Filter Section -->
    <div class="bg-white p-4 rounded shadow mb-4">
        <form id="filterForm" method="GET" action="<?php echo e(route('admin.returnedBooks')); ?>" class="space-y-4">
            <!-- Search and Date Range Controls -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search Input -->
                <div class="col-span-1 md:col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input
                        type="text"
                        id="search"
                        name="search"
                        placeholder="Search by title, author, student ID, or name..."
                        value="<?php echo e(request('search')); ?>"
                        class="w-full px-3 py-2 border rounded focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Date Range Inputs -->
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                    <input
                        type="date"
                        id="date_from"
                        name="date_from"
                        value="<?php echo e(request('date_from')); ?>"
                        class="w-full px-3 py-2 border rounded focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                    <input
                        type="date"
                        id="date_to"
                        name="date_to"
                        value="<?php echo e(request('date_to')); ?>"
                        class="w-full px-3 py-2 border rounded focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <!-- Filter Controls -->
            <div class="flex flex-wrap items-center gap-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Apply Filters
                </button>

                <?php if(request()->hasAny(['search', 'date_from', 'date_to'])): ?>
                <a href="<?php echo e(route('admin.returnedBooks')); ?>" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Clear Filters
                </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Stats Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div class="bg-blue-50 p-4 rounded">
            <h3 class="font-bold text-blue-800">Total Returns Today</h3>
            <p class="text-2xl"><?php echo e($stats['today']); ?></p>
        </div>
        <div class="bg-green-50 p-4 rounded">
            <h3 class="font-bold text-green-800">Total Returns This Month</h3>
            <p class="text-2xl"><?php echo e($stats['month']); ?></p>
        </div>
        <div class="bg-purple-50 p-4 rounded">
            <h3 class="font-bold text-purple-800">All Time Returns</h3>
            <p class="text-2xl"><?php echo e($stats['total']); ?></p>
        </div>
    </div>

    <!-- Results Section -->
    <div class="bg-white p-4 rounded shadow">
        <?php if(session('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <?php echo e(session('success')); ?>

        </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?php echo e(session('error')); ?>

        </div>
        <?php endif; ?>

        <!-- Returned Books List -->
        <div class="space-y-4">
            <?php $__empty_1 = true; $__currentLoopData = $returnedBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $borrow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="p-4 bg-gray-50 border rounded hover:bg-gray-100 transition-colors">
                <div class="flex flex-wrap justify-between items-start gap-4">
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-800"><?php echo e($borrow->book->title); ?></h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
                            <!-- Book Details -->
                            <div>
                                <p class="text-gray-600"><strong>Author:</strong> <?php echo e($borrow->book->author); ?></p>
                                <p class="text-gray-600"><strong>ISBN:</strong> <?php echo e($borrow->book->isbn); ?></p>
                            </div>

                            <!-- Student Information -->
                            <div>
                                <p class="text-gray-600"><strong>Student:</strong> <?php echo e($borrow->user->name); ?></p>
                                <p class="text-gray-600"><strong>ID:</strong> <?php echo e($borrow->id_number); ?></p>
                                <p class="text-gray-600"><strong>Course:</strong> <?php echo e($borrow->course); ?></p>
                            </div>

                            <!-- Dates -->
                            <div>
                                <p class="text-gray-600">
                                    <strong>Borrowed:</strong> <?php echo e(Carbon\Carbon::parse($borrow->borrow_date)->format('M d, Y')); ?>

                                </p>
                                <p class="text-gray-600">
                                    <strong>Returned:</strong> <?php echo e(Carbon\Carbon::parse($borrow->returned_at)->format('M d, Y')); ?>

                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center py-8 text-gray-500">
                <p class="text-xl">No returned books found.</p>
                <?php if(request()->hasAny(['search', 'date_from', 'date_to'])): ?>
                <p class="mt-2">Try adjusting your search filters.</p>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            <?php echo e($returnedBooks->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterForm = document.getElementById('filterForm');
        const searchInput = document.getElementById('search');
        const dateFromInput = document.getElementById('date_from');
        const dateToInput = document.getElementById('date_to');
        let searchTimeout;

        // Debounced search
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                filterForm.submit();
            }, 500);
        });

        // Date validation and auto-submit
        dateFromInput.addEventListener('change', function() {
            if (dateToInput.value && this.value > dateToInput.value) {
                dateToInput.value = this.value;
            }
            dateToInput.min = this.value;
            filterForm.submit();
        });

        dateToInput.addEventListener('change', function() {
            if (dateFromInput.value && this.value < dateFromInput.value) {
                dateFromInput.value = this.value;
            }
            dateFromInput.max = this.value;
            filterForm.submit();
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\LARAVEL\tatan\CTU-DANAO-LIBRARY-SYSTEM\resources\views/admin/returned_books.blade.php ENDPATH**/ ?>