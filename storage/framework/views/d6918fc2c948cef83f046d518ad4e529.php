<?php $__env->startSection('title', 'Lost Item Logs'); ?>
<?php $__env->startSection('header', 'Lost Item Logs'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Lost Item Logs</h2>
        <button id="downloadPdf" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors">
            Download PDF
        </button>
    </div>

    <div class="bg-white rounded-lg shadow-md">
        <table id="lostItemLogsTable" class="w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="px-4 py-3 text-left">Item Type</th>
                    <th class="px-4 py-3 text-left">Description</th>
                    <th class="px-4 py-3 text-left">Date Lost</th>
                    <th class="px-4 py-3 text-left">Location</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Reported By</th>
                    <th class="px-4 py-3 text-left">Reported At</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $lostItemLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="border-b border-gray-200">
                    <td class="px-4 py-3"><?php echo e($item->item_type); ?></td>
                    <td class="px-4 py-3"><?php echo e($item->description); ?></td>
                    <td class="px-4 py-3"><?php echo e($item->date_lost->format('F j, Y')); ?></td>
                    <td class="px-4 py-3"><?php echo e($item->location); ?></td>
                    <td class="px-4 py-3">
                        <span class="<?php echo e($item->status == 'found' ? 'text-green-600' : 'text-red-600'); ?>">
                            <?php echo e(ucfirst($item->status)); ?>

                        </span>
                    </td>
                    <td class="px-4 py-3"><?php echo e($item->user->name); ?></td>
                    <td class="px-4 py-3"><?php echo e($item->created_at->format('F j, Y H:i:s')); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
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
    doc.text('Lost Item Logs', 14, 20);
    
    // Create table data
    const tableData = Array.from(document.querySelectorAll('#lostItemLogsTable tbody tr'))
        .map(row => {
            const cells = row.querySelectorAll('td');
            return [
                cells[0].textContent.trim(),
                cells[1].textContent.trim(),
                cells[2].textContent.trim(),
                cells[3].textContent.trim(),
                cells[4].textContent.trim(),
                cells[5].textContent.trim(),
                cells[6].textContent.trim()
            ];
        });

    // Generate table
    doc.autoTable({
        startY: 30,
        head: [['Item Type', 'Description', 'Date Lost', 'Location', 'Status', 'Reported By', 'Reported At']],
        body: tableData,
        theme: 'striped',
        styles: { fontSize: 10 },
        headStyles: { fillColor: [41, 128, 185], textColor: 255 }
    });

    // Save the PDF
    doc.save('lost_item_logs.pdf');
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.superadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\git\Final-Library-System-Capstone-1\final-1\resources\views/super-admin/lost-item-logs.blade.php ENDPATH**/ ?>