<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Car $car
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Car'), ['action' => 'edit', $car->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Car'), ['action' => 'delete', $car->id], ['confirm' => __('Are you sure you want to delete # {0}?', $car->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Cars'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Car'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="cars view content">
            <h3><?= h($car->plate_number) ?></h3>
            <table>
                <tr>
                    <th><?= __('Plate Number') ?></th>
                    <td><?= h($car->plate_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Car Model') ?></th>
                    <td><?= h($car->car_model) ?></td>
                </tr>
                <tr>
                    <th><?= __('Engine Capacity') ?></th>
                    <td><?= h($car->engine_capacity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Availability Status') ?></th>
                    <td><?= h($car->availability_status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($car->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Daily Rate') ?></th>
                    <td><?= $this->Number->format($car->daily_rate) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($car->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($car->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Bookings') ?></h4>
                <?php if (!empty($car->bookings)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Start Date') ?></th>
                            <th><?= __('End Date') ?></th>
                            <th><?= __('Rental Price') ?></th>
                            <th><?= __('Deposit Amount') ?></th>
                            <th><?= __('Total Price') ?></th>
                            <th><?= __('Booking Status') ?></th>
                            <th><?= __('Lockbox Pin') ?></th>
                            <th><?= __('Deposit Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($car->bookings as $booking) : ?>
                        <tr>
                            <td><?= h($booking->id) ?></td>
                            <td><?= h($booking->customer_id) ?></td>
                            <td><?= h($booking->start_date) ?></td>
                            <td><?= h($booking->end_date) ?></td>
                            <td><?= h($booking->rental_price) ?></td>
                            <td><?= h($booking->deposit_amount) ?></td>
                            <td><?= h($booking->total_price) ?></td>
                            <td><?= h($booking->booking_status) ?></td>
                            <td><?= h($booking->lockbox_pin) ?></td>
                            <td><?= h($booking->deposit_status) ?></td>
                            <td><?= h($booking->created) ?></td>
                            <td><?= h($booking->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Bookings', 'action' => 'view', $booking->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Bookings', 'action' => 'edit', $booking->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Bookings', 'action' => 'delete', $booking->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $booking->id),
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