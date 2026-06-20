<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - SF Car Rental</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <?= $this->Html->css('admin-login') ?>
</head>
<body>

    <button id="theme-toggle" class="theme-toggle" aria-label="Toggle Dark/Light Mode">
        <i id="theme-icon" class="fas fa-moon"></i>
    </button>

    <div class="login-container">
        <div class="logo-text">SF <span>Adib Car rental</span></div>
        
        <div class="flash-message">
            <?= $this->Flash->render() ?>
        </div>

        <?= $this->Form->create() ?>
            <div class="input-group">
                <label>Username</label>
                <?= $this->Form->text('username', ['required' => true, 'placeholder' => 'Enter username']) ?>
            </div>
            
            <div class="input-group">
                <label>Password</label>
                <?= $this->Form->password('password', ['required' => true, 'placeholder' => 'Enter password']) ?>
            </div>
            
            <?= $this->Form->button('Login', ['class' => 'btn-login']) ?>
        <?= $this->Form->end() ?>
    </div>

    <?= $this->Html->script('admin-login') ?>
</body>
</html>