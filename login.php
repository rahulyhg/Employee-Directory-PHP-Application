<?php include('partials/header.php');
// if already logged in, go to index
if( $session->is_logged_in() ) {
    redirect('index');
}

// if form has been submitted,
if(isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if( !empty($username) && !empty($password) ) {
        // method to check database user
        $user_data = User::verify_user($username, $password);

        if($user_data){
            // get employee data based off employee_id
            $employee_data = Employee::find_employee_by_id($user_data['employee_id']);
            $user_data['display_name'] = ($employee_data['first_name'] . ' ' . $employee_data['last_name']);

            $session->login($user_data);
            redirect('index');
        } else {
            $message = 'Your password or username is incorrect!';
        }
    } else {
        if( empty($username) ) {
            $user_error = 'Username is required';
        }
        if( empty($password) ) {
            $pass_error = 'Password is required';
        }
    }
} else {
    $message = $user_error = $pass_error = '';
    $username = '';
    $password = '';
} ?>
<div class="login-form-container">
    <div class="row">
        <div class="columns">
            <h1>Employee Directory Application</h1>
            Please log in below
        </div>
    </div>
    <form id="login-form" action="" method="post">
        <div class="row">
            <div class="columns">
                <?php if( !empty($message) ) : ?>
                    <div class="callout alert"><?php echo $message; ?></div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="columns">
                <label>Username
                    <input type="text" name="username" placeholder="Enter Your Username" value="<?php echo htmlentities($username); ?>">
                </label>
                <?php if( !empty($user_error) ) : ?>
                    <div class="callout alert"><?php echo $user_error; ?></div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="columns">
                <label>Password
                    <input type="password" name="password" placeholder="Enter Your Password" value="<?php echo htmlentities($password); ?>">
                </label>
                <?php if( !empty($pass_error) ) : ?>
                    <div class="callout alert"><?php echo $pass_error; ?></div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="columns">
                <button type="submit" name="submit" class="button">Submit</button>
            </div>
        </div>
    </form>
</div>

<?php include('partials/footer.php'); ?>