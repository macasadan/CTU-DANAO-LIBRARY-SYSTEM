<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Returned Book Logs</h1>
        <button id="downloadPdf" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors">
            Download PDF
        </button>
    </div>

    <div id="returnedBooksTable" class="hidden">
        <table>
            <thead>
                <tr>
                    <th>Book Title</th>
                    <th>Author</th>
                    <th>User</th>
                    <th>Borrowed Date</th>
                    <th>Returned Date</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $returnedBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $borrow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($borrow->book->title); ?></td>
                    <td><?php echo e($borrow->book->author); ?></td>
                    <td><?php echo e($borrow->user->name); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($borrow->borrow_date)->format('Y-m-d H:i')); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($borrow->returned_at)->format('Y-m-d H:i')); ?></td>
                    <td><?php echo e($borrow->return_notes ?? 'N/A'); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <div class="space-y-4">
        <?php $__empty_1 = true; $__currentLoopData = $returnedBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $borrow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="p-4 bg-gray-50 border rounded hover:bg-gray-100 transition-colors">
            <div class="flex flex-wrap justify-between items-start gap-4">
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-gray-800"><?php echo e($borrow->book->title); ?></h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-2">
                        <div>
                            <p class="text-gray-600"><strong>Author:</strong> <?php echo e($borrow->book->author); ?></p>
                            <p class="text-gray-600"><strong>User:</strong> <?php echo e($borrow->user->name); ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600">
                                <strong>Borrowed:</strong>
                                <?php echo e(\Carbon\Carbon::parse($borrow->borrow_date)->format('Y-m-d H:i')); ?>

                            </p>
                            <p class="text-gray-600">
                                <strong>Returned:</strong>
                                <?php echo e(\Carbon\Carbon::parse($borrow->returned_at)->format('Y-m-d H:i')); ?>

                                (<?php echo e(\Carbon\Carbon::parse($borrow->returned_at)->diffForHumans()); ?>)
                            </p>
                        </div>
                    </div>
                    <?php if($borrow->return_notes): ?>
                    <p class="mt-2 text-gray-600">
                        <strong>Notes:</strong> <?php echo e($borrow->return_notes); ?>

                    </p>
                    <?php endif; ?>
                </div>
                <div class="bg-green-100 px-3 py-1 rounded-full text-green-800 text-sm">
                    Returned
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="text-center py-8 text-gray-500">
            <p class="text-xl">No returned books found.</p>
        </div>
        <?php endif; ?>
    </div>

    <!-- Pagination Links -->
    <div class="mt-4">
        <?php echo e($returnedBooks->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>
<script>
document.getElementById('downloadPdf').addEventListener('click', function() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('landscape');
    
    // Add title
    doc.setFontSize(18);
    doc.text('Returned Book Logs', 14, 20);
    
    // Create table data
    const tableData = Array.from(document.querySelectorAll('#returnedBooksTable tbody tr'))
        .map(row => {
            const cells = row.querySelectorAll('td');
            return [
                cells[0].textContent.trim(),
                cells[1].textContent.trim(),
                cells[2].textContent.trim(),
                cells[3].textContent.trim(),
                cells[4].textContent.trim(),
                cells[5].textContent.trim()
            ];
        });

    // Generate table
    doc.autoTable({
        startY: 30,
        head: [['Book Title', 'Author', 'User', 'Borrowed Date', 'Returned Date', 'Notes']],
        body: tableData,
        theme: 'striped',
        styles: { fontSize: 10 },
        headStyles: { fillColor: [41, 128, 185], textColor: 255 }
    });

    // Save the PDF
    doc.save('returned_book_logs.pdf');
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.superadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\git\Final-Library-System-Capstone-1\final-1\resources\views/super-admin/returned-book-logs.blade.php ENDPATH**/ ?>