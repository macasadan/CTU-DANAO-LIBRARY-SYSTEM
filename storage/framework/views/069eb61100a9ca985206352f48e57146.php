
<?php $__env->startSection('title', 'Manage Books'); ?>
<?php $__env->startSection('header', 'Books Management'); ?>
<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Books List</h2>
        <button id="downloadPdf" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors">
            Download PDF
        </button>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Published Year</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($book->id); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($book->title); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($book->author); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($book->published_year); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($book->categories->pluck('name')->implode(', ')); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($book->quantity); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="<?php echo e(route('super-admin.books.show', $book->id)); ?>"
                            class="text-blue-600 hover:text-blue-900">View Details</a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                        No books found.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <?php echo e($books->links()); ?>

    </div>
</div>
<?php $__env->startPush('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>
<script>
    document.getElementById('downloadPdf').addEventListener('click', function() {
        const {
            jsPDF
        } = window.jspdf;
        const doc = new jsPDF('landscape');

        // Add title
        doc.setFontSize(18);
        doc.text('Books List', 14, 20);

        // Create table data directly from Blade-rendered rows
        const tableData = Array.from(document.querySelectorAll('tbody tr'))
            .filter(row => row.querySelector('td:first-child').textContent !== 'No books found.')
            .map(row => {
                const cells = row.querySelectorAll('td');
                return [
                    cells[0].textContent,
                    cells[1].textContent,
                    cells[2].textContent,
                    cells[3].textContent,
                    cells[4].textContent,
                    cells[5].textContent
                ];
            });

        // Generate table
        doc.autoTable({
            startY: 30,
            head: [
                ['ID', 'Title', 'Author', 'Published Year', 'Category', 'Quantity']
            ],
            body: tableData,
            theme: 'striped',
            styles: {
                fontSize: 10
            },
            headStyles: {
                fillColor: [41, 128, 185],
                textColor: 255
            }
        });

        // Save the PDF
        doc.save('books_list.pdf');
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.superadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\LARAVEL\tatan\CTU-DANAO-LIBRARY-SYSTEM\resources\views/super-admin/books/index.blade.php ENDPATH**/ ?>