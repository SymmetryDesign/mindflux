<?php

/*--------------------------------------------------------------------------*
 * Frontend Routes
 *--------------------------------------------------------------------------*/
Route::group(['namespace' => 'Web\Front'], function () {
    /**
     * Home
     */
    if (settings('custom_homepage.enabled', false)) {
        Route::get('/', function () {
            return response(
                file_get_contents(settings('custom_homepage.url'))
            );
        })->name('home');
    } else {
        Route::get('/', 'HomeController@index')->name('home');
    }

    /**
     * Auth
     */
    Route::get('login', 'Auth\LoginController@show')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

    /**
     * Forgot Password
     */
    Route::get('password/reminder', 'Auth\ForgotPasswordController@show')->name('password.reminder');
    Route::post('password/reminder', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.reminder.send');
    Route::get('password/reset', 'Auth\ResetPasswordController@show')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset.post');

    /**
     * Register
     */
    Route::get('register', 'Auth\RegisterController@show')->name('register');
    Route::post('register', 'Auth\RegisterController@register');

    /**
     * Terms and Conditions
     */
    if (settings('terms_and_conditions.published', false)) {
        Route::get('terms-and-conditions', 'TermsAndConditionsController@index')->name('terms-and-conditions');
    }

    /**
     * Privacy Policy
     */
    if (settings('privacy_policy.published', false)) {
        Route::get('privacy-policy', 'PrivacyPolicyController@index')->name('privacy-policy');
    }

    /**
     * Payment Gateways Webhook Handler
     */
    if (config('billing.gateway') === 'braintree') {
        Route::post('webhook/{secret}', 'BraintreeWebhookController@handleWebhook')->name('webhook.handler');
    }

    if (config('billing.gateway') === 'stripe') {
        Route::post('webhook/{secret}', 'StripeWebhookController@handleWebhook')->name('webhook.handler');
    }

    /**
     * Localization
     */
    Route::get('js/localization.js', 'LocalizationController@index')->name('assets.localization');
});


/*--------------------------------------------------------------------------*
 * Admin Routes
 *--------------------------------------------------------------------------*/
Route::group(['namespace' => 'Web\Back\Admin', 'prefix' => 'admin', 'as' => 'admin:'], function () {
    /**
     * Dashboard
     */
    Route::get('/', 'DashboardController@index')->name('dashboard');

    /**
     * Subscriptions
     */
    Route::get('subscriptions', 'SubscriptionsController@index')->name('subscriptions.index');
    Route::get('subscriptions/{subscription}', 'SubscriptionsController@show')->name('subscriptions.show');

    /**
     * Plans
     */
    Route::get('plans', 'PlansController@index')->name('plans.index');
    Route::get('plans/create', 'PlansController@create')->name('plans.create');
    Route::get('plans/{plan}/edit', 'PlansController@edit')->name('plans.edit');
    Route::post('plans', 'PlansController@store')->name('plans.store');
    Route::put('plans/{plan}', 'PlansController@update')->name('plans.update');

    /**
     * Customers
     */
    Route::get('customers', 'CustomersController@index')->name('customers.index');
    Route::get('customers/{customer}', 'CustomersController@show')->name('customers.show');

    /**
     * Profile
     */
    Route::get('account/profile', 'Account\ProfileController@edit')->name('profile.edit');
    Route::put('account/profile', 'Account\ProfileController@update')->name('profile.update');

    /**
     * Password
     */
    Route::get('account/password', 'Account\PasswordController@edit')->name('password.edit');
    Route::put('account/password', 'Account\PasswordController@update')->name('password.update');

    /**
     * System Settings
     */
    Route::get('settings', 'Settings\SystemSettingsController@edit')->name('system-settings.edit');
    Route::put('settings', 'Settings\SystemSettingsController@update')->name('system-setings.update');

    /**
     * Landing Page Settings
     */
    Route::get('settings/landing', 'Settings\LandingPageSettingsController@edit')->name('landing-page-settings.edit');
    Route::put('settings/landing/hero-settings', 'Settings\HeroSettingsController@update')->name('landing-page-hero-settings.update');
    Route::put('settings/landing/pricing-settings', 'Settings\PricingSettingsController@update')->name('landing-page-pricing-settings.update');
    Route::put('settings/landing/features-settings', 'Settings\FeaturesSettingsController@update')->name('landing-page-features-settings.update');

    Route::post('settings/landing/features', 'Settings\FeaturesController@store')->name('landing-page-features.store');
    Route::put('settings/landing/features/{feature}', 'Settings\FeaturesController@update')->name('landing-page-features.update');
    Route::delete('settings/landing/features/{feature}', 'Settings\FeaturesController@destroy')->name('landing-page-features.destroy');

    /**
     * Privacy Policy
     */
    Route::get('settings/privacy-policy', 'Settings\PrivacyPolicyController@edit')->name('privacy-policy.edit');
    Route::put('settings/privacy-policy', 'Settings\PrivacyPolicyController@update')->name('privacy-policy.update');

    /**
     * Terms and Conditions
     */
    Route::get('settings/terms-and-conditions', 'Settings\TermsAndConditionsController@edit')->name('terms-and-conditions.edit');
    Route::put('settings/terms-and-conditions', 'Settings\TermsAndConditionsController@update')->name('terms-and-conditions.update');

    /**
     * Homepage Settings
     */
    Route::get('settings/homepage', 'Settings\HomepageSettingsController@edit')->name('homepage-settings.edit');
    Route::put('settings/homepage', 'Settings\HomepageSettingsController@update')->name('homepage-settings.update');

    /**
     * Web Hook
     */
    Route::get('settings/webhook', 'Settings\WebhookController@index')->name('webhook');
});


/*--------------------------------------------------------------------------*
 * App Routes
 *--------------------------------------------------------------------------*/
Route::group(['namespace' => 'Web\Back\App', 'prefix' => 'app', 'as' => 'app:'], function () {
    /**
     * Dashboard
     */
    Route::get('/', 'DashboardController@index')->name('dashboard');

    /**
     * Profile
     */
    Route::get('account/profile', 'Account\ProfileController@edit')->name('profile.edit');
    Route::put('account/profile', 'Account\ProfileController@update')->name('profile.update');

    /**
     * Password
     */
    Route::get('account/password', 'Account\PasswordController@edit')->name('password.edit');
    Route::put('account/password', 'Account\PasswordController@update')->name('password.update');

    /**
     * Email Notifications
     */
    Route::get('account/email-notifications', 'Account\EmailNotificationsController@edit')->name('email-notifications.edit');
    Route::put('account/email-notifications', 'Account\EmailNotificationsController@update')->name('email-notifications.update');

    /**
     * System Preferences
     */
    Route::get('account/system-preferences', 'Account\SystemPreferencesController@edit')->name('system-preferences.edit');
    Route::put('account/system-preferences', 'Account\SystemPreferencesController@update')->name('system-preferences.update');

    /**
     * Projects
     */
    Route::resource('projects', 'Projects\ProjectsController');
    Route::put('projects/{project}/restore', 'Projects\ProjectsController@restore')->name('projects.restore');

    /**
     * Complete Projects
     */
    Route::post('projects/{project}/complete', 'Projects\CompleteProjectsController@store')->name('projects.complete.store');
    Route::delete('projects/{project}/complete', 'Projects\CompleteProjectsController@destroy')->name('projects.complete.destroy');

    /**
     * Favorite Projects
     */
    Route::post('favorite-projects', 'Projects\FavoriteProjectsController@store')->name('favorite-projects.store');
    Route::delete('favorite-projects/{project}', 'Projects\FavoriteProjectsController@destroy')->name('favorite-projects.destroy');

    /**
     * Project Columns
     */
    Route::post('projects/{project}/columns', 'Projects\ProjectColumnsController@store')->name('project.columns.store');
    Route::put('projects/{project}/columns/sort', 'Projects\ProjectColumnsSortController@update')->name('project.columns.sort.update');
    Route::put('projects/{project}/columns/{column}', 'Projects\ProjectColumnsController@update')->name('project.columns.update');
    Route::delete('projects/{project}/columns/{column}', 'Projects\ProjectColumnsController@destroy')->name('project.columns.destroy');

    /**
     * Project Tasks
     */
    Route::put('projects/{project}/tasks/{task}', 'Projects\ProjectTasksController@update')->name('project.tasks.update');
    Route::post('projects/{project}/columns/{column}/tasks', 'Projects\ProjectTasksController@store')->name('project.tasks.store');
    Route::put('projects/{project}/columns/{column}/tasks/sort', 'Projects\ProjectTasksSortController@update')->name('project.tasks.sort.update');
    Route::delete('projects/{project}/tasks/{task}', 'Projects\ProjectTasksController@destroy')->name('project.tasks.destroy');

    /**
     * Project Watchers
     */
    Route::post('projects/{project}/watchers', 'Projects\ProjectWatchersController@store')->name('project.watchers.store');
    Route::delete('projects/{project}/watchers', 'Projects\ProjectWatchersController@destroy')->name('project.watchers.destroy');

    /**
     * Task Comments
     */
    Route::get('projects/{project}/tasks/{task}/comments', 'Projects\TaskCommentsController@index')->name('project.task.comments.index');
    Route::post('projects/{project}/tasks/{task}/comments', 'Projects\TaskCommentsController@store')->name('project.task.comments.store');

    /**
     * Sub Tasks
     */
    Route::get('projects/{project}/tasks/{task}/subtasks', 'Projects\ProjectSubTasksController@index')->name('project.task.sub-tasks.index');
    Route::post('projects/{project}/tasks/{task}/subtasks', 'Projects\ProjectSubTasksController@store')->name('project.task.sub-tasks.store');

    /**
     * Task Attachments
     */
    Route::get('projects/{project}/tasks/{task}/attachments', 'Projects\TaskAttachmentsController@index')->name('project.task.attachments.index');
    Route::get('projects/{project}/attachments/{attachment}/download', 'Projects\ProjectAttachmentsDownloadController@get')->name('project.attachments.download');
    Route::post('projects/{project}/tasks/{task}/attachments', 'Projects\TaskAttachmentsController@store')->name('project.task.attachments.store');
    Route::get('projects/{project}/tasks/{task}/attachments', 'Projects\TaskAttachmentsController@index')->name('project.task.attachments.index');

    /**
     * My Tasks
     */
    Route::get('tasks', 'TasksController@index')->name('tasks.index');

    /**
     * Calendar
     */
    Route::get('calendar', 'CalendarController@index')->name('calendar.index');

    /**
     * Team Members
     */
    Route::get('settings/users', 'Settings\UsersController@index')->name('users.index');
    Route::post('settings/users', 'Settings\UsersController@store')->name('users.store');
    Route::put('settings/users/{user}', 'Settings\UsersController@update')->name('users.update');

    /**
     * Subscription
     */
    Route::get('settings/subscription', 'Settings\SubscriptionController@index')->name('subscription');
    Route::post('settings/subscription', 'Settings\SubscriptionController@store')->name('subscription.store');
    Route::delete('settings/subscription', 'Settings\SubscriptionController@destroy')->name('subscription.destroy');

    /**
     * Customer Credit Cards
     */
    Route::post('settings/payment-methods', 'Settings\PaymentMethodsController@store')->name('payment-methods.store');
    Route::put('settings/payment-methods/{payment_method}', 'Settings\PaymentMethodsController@update')->name('payment-methods.update');
    Route::delete('settings/payment-methods/{payment_method}', 'Settings\PaymentMethodsController@destroy')->name('payment-methods.destroy');

    /**
     * Billing Information
     */
    Route::get('settings/billing-information', 'Settings\BillingInformationController@edit')->name('billing-information.edit');
    Route::put('settings/billing-information', 'Settings\BillingInformationController@update')->name('billing-information.update');
});
