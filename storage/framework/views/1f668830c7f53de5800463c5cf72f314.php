

<?php $__env->startSection('title', 'Report Logs'); ?>
<?php $__env->startSection('header', 'Report Logs'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Report Logs</h2>
        <div class="flex space-x-4">
            <form class="flex space-x-2" action="<?php echo e(route('super-admin.report-logs')); ?>" method="GET">
                <select name="status" 
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200">
                    <option value="">All Status</option>
                    <option value="approved" <?php echo e(request('status') === 'approved' ? 'selected' : ''); ?>>Currently Borrowed</option>
                    <option value="returned" <?php echo e(request('status') === 'returned' ? 'selected' : ''); ?>>Returned</option>
                </select>
                <input type="text"
                    name="search"
                    value="<?php echo e(request('search')); ?>"
                    placeholder="Search by title or student name"
                    class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200">
                <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600">
                    Search
                </button>
            </form>
            <button id="downloadPdf" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors">
                Download PDF
            </button>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md">
        <table id="reportLogsTable" class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Number</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Borrow Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Return Date</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $allBorrows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $borrow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900"><?php echo e($borrow->book->title); ?></td>
                    <td class="px-6 py-4 text-sm text-gray-500"><?php echo e($borrow->user->name); ?></td>
                    <td class="px-6 py-4 text-sm text-gray-500"><?php echo e($borrow->id_number); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            <?php echo e($borrow->returned_at 
                                ? 'bg-gray-100 text-gray-800'
                                : 'bg-green-100 text-green-800'); ?>">
                            <?php echo e($borrow->returned_at ? 'Returned' : 'Currently Borrowed'); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        <?php echo e($borrow->borrow_date ? $borrow->borrow_date->format('M d, Y') : '-'); ?>

                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        <?php echo e($borrow->due_date ? $borrow->due_date->format('M d, Y') : '-'); ?>

                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        <?php echo e($borrow->returned_at ? $borrow->returned_at->format('M d, Y') : '-'); ?>

                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        No reports found.
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>
<script>
document.getElementById('downloadPdf').addEventListener('click', function() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('landscape');
    
    // Add title
    doc.setFontSize(18);
    doc.text('Report Logs', 14, 20);
    
    // Create table data
    const tableData = Array.from(document.querySelectorAll('#reportLogsTable tbody tr'))
        .map(row => {
            const cells = row.querySelectorAll('td');
            return [
                cells[0].textContent.trim(), // Book Title
                cells[1].textContent.trim(), // Student Name
                cells[2].textContent.trim(), // ID Number
                cells[3].textContent.trim(), // Status
                cells[4].textContent.trim(), // Borrow Date
                cells[5].textContent.trim(), // Due Date
                cells[6].textContent.trim()  // Return Date
            ];
        });

    // Generate table
    doc.autoTable({
        startY: 30,
        head: [['Book Title', 'Student Name', 'ID Number', 'Status', 'Borrow Date', 'Due Date', 'Return Date']],
        body: tableData,
        theme: 'striped',
        styles: { fontSize: 10 },
        headStyles: { fillColor: [79, 70, 229], textColor: 255 } // Indigo color to match theme
    });

    // Save the PDF
    doc.save('report_logs.pdf');
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.superadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\LARAVEL\tatan\CTU-DANAO-LIBRARY-SYSTEM\resources\views/super-admin/report-logs.blade.php ENDPATH**/ ?>