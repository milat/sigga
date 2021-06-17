<?php

use App\Utils\Language;

/**
 *  @var string Divider between parent and child
 */
$divider = " > ";

/**
 *  Used on migrations and seeders
 */
return [

    [
        'label' => Language::get('dashboard'),
        'code' => 'dashboard',
        'parent' => null
    ],

    [
        'label' => Language::get('requests'),
        'code' => 'request',
        'parent' => null
    ],

    [
        'label' => Language::get('requests').$divider.Language::get('insert'),
        'code' => 'request.insert',
        'parent' => 'request'
    ],

    [
        'label' => Language::get('requests').$divider.Language::get('update'),
        'code' => 'request.update',
        'parent' => 'request'
    ],

    [
        'label' => Language::get('citizens'),
        'code' => 'citizen',
        'parent' => null
    ],

    [
        'label' => Language::get('citizens').$divider.Language::get('insert'),
        'code' => 'citizen.insert',
        'parent' => 'citizen'
    ],

    [
        'label' => Language::get('citizens').$divider.Language::get('update'),
        'code' => 'citizen.update',
        'parent' => 'citizen'
    ],

    [
        'label' => Language::get('organizations'),
        'code' => 'organization',
        'parent' => null
    ],

    [
        'label' => Language::get('organizations').$divider.Language::get('insert'),
        'code' => 'organization.insert',
        'parent' => 'organization'
    ],

    [
        'label' => Language::get('organizations').$divider.Language::get('update'),
        'code' => 'organization.update',
        'parent' => 'organization'
    ],

    [
        'label' => Language::get('documents'),
        'code' => 'document',
        'parent' => null
    ],

    [
        'label' => Language::get('documents').$divider.Language::get('insert'),
        'code' => 'document.insert',
        'parent' => 'document'
    ],

    [
        'label' => Language::get('documents').$divider.Language::get('update'),
        'code' => 'document.update',
        'parent' => 'document'
    ],

    [
        'label' => Language::get('attachments'),
        'code' => 'attachment',
        'parent' => null
    ],

    [
        'label' => Language::get('attachments').$divider.Language::get('insert'),
        'code' => 'attachment.insert',
        'parent' => 'attachment'
    ],

    [
        'label' => Language::get('attachments').$divider.Language::get('update'),
        'code' => 'attachment.update',
        'parent' => 'attachment'
    ],

    [
        'label' => Language::get('activities'),
        'code' => 'activity',
        'parent' => null
    ],

    [
        'label' => Language::get('activities').$divider.Language::get('insert'),
        'code' => 'activity.insert',
        'parent' => 'activity'
    ],

    [
        'label' => Language::get('activities').$divider.Language::get('update'),
        'code' => 'activity.update',
        'parent' => 'activity'
    ],

    [
        'label' => Language::get('activities').$divider.Language::get('activity_class'),
        'code' => 'activity_class',
        'parent' => 'activity'
    ],

    [
        'label' => Language::get('activities').$divider.Language::get('activity_class').$divider.Language::get('insert'),
        'code' => 'activity_class.insert',
        'parent' => 'activity'
    ],

    [
        'label' => Language::get('activities').$divider.Language::get('activity_class').$divider.Language::get('update'),
        'code' => 'activity_class.update',
        'parent' => 'activity'
    ],

    [
        'label' => Language::get('activities').$divider.Language::get('activity_lesson'),
        'code' => 'activity_lesson',
        'parent' => 'activity'
    ],

    [
        'label' => Language::get('activities').$divider.Language::get('activity_lesson').$divider.Language::get('insert'),
        'code' => 'activity_lesson.insert',
        'parent' => 'activity'
    ],

    [
        'label' => Language::get('activities').$divider.Language::get('activity_lesson').$divider.Language::get('update'),
        'code' => 'activity_lesson.update',
        'parent' => 'activity'
    ],

    [
        'label' => Language::get('activities').$divider.Language::get('activity_subscribe'),
        'code' => 'activity_subscribe',
        'parent' => 'activity'
    ],

    [
        'label' => Language::get('activities').$divider.Language::get('activity_subscribe').$divider.Language::get('insert'),
        'code' => 'activity_subscribe.insert',
        'parent' => 'activity'
    ],

    [
        'label' => Language::get('activities').$divider.Language::get('activity_subscribe').$divider.Language::get('update'),
        'code' => 'activity_subscribe.update',
        'parent' => 'activity'
    ],

    [
        'label' => Language::get('activities').$divider.Language::get('activity_attend'),
        'code' => 'activity_attend',
        'parent' => 'activity'
    ],

    [
        'label' => Language::get('configs'),
        'code' => 'config',
        'parent' => null
    ],

    [
        'label' => Language::get('configs').$divider.Language::get('users'),
        'code' => 'user',
        'parent' => 'config'
    ],

    [
        'label' => Language::get('configs').$divider.Language::get('users').$divider.Language::get('insert'),
        'code' => 'user.insert',
        'parent' => 'user'
    ],

    [
        'label' => Language::get('configs').$divider.Language::get('users').$divider.Language::get('update'),
        'code' => 'user.update',
        'parent' => 'user'
    ],

    [
        'label' => Language::get('configs').$divider.Language::get('roles'),
        'code' => 'role',
        'parent' => 'config'
    ],

    [
        'label' => Language::get('configs').$divider.Language::get('roles').$divider.Language::get('insert'),
        'code' => 'role.insert',
        'parent' => 'role'
    ],

    [
        'label' => Language::get('configs').$divider.Language::get('roles').$divider.Language::get('update'),
        'code' => 'role.update',
        'parent' => 'role'
    ],

    [
        'label' => Language::get('configs').$divider.Language::get('roles').$divider.Language::get('permissions'),
        'code' => 'role.permission',
        'parent' => 'role'
    ],

    [
        'label' => Language::get('configs').$divider.Language::get('categories'),
        'code' => 'category',
        'parent' => 'config'
    ],

    [
        'label' => Language::get('configs').$divider.Language::get('categories').$divider.Language::get('insert'),
        'code' => 'category.insert',
        'parent' => 'category'
    ],

    [
        'label' => Language::get('configs').$divider.Language::get('categories').$divider.Language::get('update'),
        'code' => 'category.update',
        'parent' => 'category'
    ],

];