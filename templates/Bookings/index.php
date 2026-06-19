<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Booking> $bookings
 */
?>
<div class="bookings index content">
    <?= $this->Html->link(__('New Booking'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Bookings') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('customer_id') ?></th>
                    <th><?= $this->Paginator->sort('car_id') ?></th>
                    <th><?= $this->Paginator->sort('start_date') ?></th>
                    <th><?= $this->Paginator->sort('end_date') ?></th>
                    <th><?= $this->Paginator->sort('rental_price') ?></th>
                    <th><?= $this->Paginator->sort('deposit_amount') ?></th>
                    <th><?= $this->Paginator->sort('total_price') ?></th>
                    <th><?= $this->Paginator->sort('booking_status') ?></th>
                    <th><?= $this->Paginator->sort('lockbox_pin') ?></th>
                    <th><?= $this->Paginator->sort('deposit_status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?= $this->Number->format($booking->id) ?></td>
                    <td><?= $booking->hasValue('customer') ? $this->Html->link($booking->customer->full_name, ['controller' => 'Customers', 'action' => 'view', $booking->customer->id]) : '' ?></td>
                    <td><?= $booking->hasValue('car') ? $this->Html->link($booking->car->plate_number, ['controller' => 'Cars', 'action' => 'view', $booking->car->id]) : '' ?></td>
                    <td><?= h($booking->start_date) ?></td>
                    <td><?= h($booking->end_date) ?></td>
                    <td><?= $this->Number->format($booking->rental_price) ?></td>
                    <td><?= $booking->deposit_amount === null ? '' : $this->Number->format($booking->deposit_amount) ?></td>
                    <td><?= $this->Number->format($booking->total_price) ?></td>
                    <td><?= h($booking->booking_status) ?></td>
                    <td><?= h($booking->lockbox_pin) ?></td>
                    <td><?= h($booking->deposit_status) ?></td>
                    <td><?= h($booking->created) ?></td>
                    <td><?= h($booking->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $booking->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $booking->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $booking->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $booking->id),
                            ]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>