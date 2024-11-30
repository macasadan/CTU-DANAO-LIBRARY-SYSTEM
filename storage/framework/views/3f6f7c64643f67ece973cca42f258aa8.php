

<?php $__env->startSection('title', 'Manage Books'); ?>
<?php $__env->startSection('header', 'Books Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
        
        <div class="flex flex-col sm:flex-row justify-between items-center mb-4 sm:mb-6">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4 sm:mb-0">Books List</h2>
            <a href="<?php echo e(route('admin.books.create')); ?>"
                class="w-full sm:w-auto text-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                Add New Book
            </a>
        </div>

        
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Author</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Published Year</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Category</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell"><?php echo e($book->id); ?></td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                            <?php echo e($book->title); ?>

                            
                            <div class="sm:hidden text-xs text-gray-500">
                                <p><?php echo e($book->author); ?></p>
                                <p>Published: <?php echo e($book->published_year); ?></p>
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 hidden sm:table-cell"><?php echo e($book->author); ?></td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell"><?php echo e($book->published_year); ?></td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 hidden lg:table-cell">
                            <?php echo e($book->categories->pluck('name')->implode(', ')); ?>

                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                                <a href="<?php echo e(route('admin.books.edit', $book->id)); ?>"
                                    class="text-blue-600 hover:text-blue-900 inline-block">
                                    <span class="sm:hidden">Edit</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden sm:inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="<?php echo e(route('admin.books.destroy', $book->id)); ?>"
                                    method="POST"
                                    class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-900"
                                        onclick="return confirm('Are you sure you want to delete this book?')">
                                        <span class="sm:hidden">Delete</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden sm:inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            No books found.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

   
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\LARAVEL\tatan\CTU-DANAO-LIBRARY-SYSTEM\resources\views/admin/books/index.blade.php ENDPATH**/ ?>