<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Booking $booking
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Booking'), ['action' => 'edit', $booking->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Booking'), ['action' => 'delete', $booking->id], ['confirm' => __('Are you sure you want to delete # {0}?', $booking->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Bookings'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Booking'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="bookings view content">
            <h3><?= h($booking->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Customer') ?></th>
                    <td><?= $booking->hasValue('customer') ? $this->Html->link($booking->customer->full_name, ['controller' => 'Customers', 'action' => 'view', $booking->customer->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Car') ?></th>
                    <td><?= $booking->hasValue('car') ? $this->Html->link($booking->car->plate_number, ['controller' => 'Cars', 'action' => 'view', $booking->car->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Booking Status') ?></th>
                    <td><?= h($booking->booking_status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Lockbox Pin') ?></th>
                    <td><?= h($booking->lockbox_pin) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deposit Status') ?></th>
                    <td><?= h($booking->deposit_status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($booking->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Rental Price') ?></th>
                    <td><?= $this->Number->format($booking->rental_price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deposit Amount') ?></th>
                    <td><?= $booking->deposit_amount === null ? '' : $this->Number->format($booking->deposit_amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total Price') ?></th>
                    <td><?= $this->Number->format($booking->total_price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Start Date') ?></th>
                    <td><?= h($booking->start_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('End Date') ?></th>
                    <td><?= h($booking->end_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($booking->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($booking->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Payments') ?></h4>
                <?php if (!empty($booking->payments)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Payment Time') ?></th>
                            <th><?= __('Total Payment') ?></th>
                            <th><?= __('Payment Method') ?></th>
                            <th><?= __('Payment Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($booking->payments as $payment) : ?>
                        <tr>
                            <td><?= h($payment->id) ?></td>
                            <td><?= h($payment->payment_time) ?></td>
                            <td><?= h($payment->total_payment) ?></td>
                            <td><?= h($payment->payment_method) ?></td>
                            <td><?= h($payment->payment_status) ?></td>
                            <td><?= h($payment->created) ?></td>
                            <td><?= h($payment->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Payments', 'action' => 'view', $payment->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Payments', 'action' => 'edit', $payment->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Payments', 'action' => 'delete', $payment->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $payment->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>