import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

const cssFiles = [
    'resources/css/common.css',
    'resources/css/list-user.css',
    'resources/css/list-group.css',
];

const jsFiles = [
    'resources/js/common.js',
    'resources/js/nocache.js',
    'resources/js/lib/jquery-validation/additional-setting.js',
    'resources/js/lib/jquery-validation/my-validation.js',
    'resources/js/screens/auth/login.js',
    'resources/js/screens/user/userList.js',
    'resources/js/screens/user/userAdd.js',
    'resources/js/screens/user/userEdit.js',
    'resources/js/lib/jquery-validation/my-validate-message.js',
    'resources/js/screens/group/groupList.js',
];

export default defineConfig({
    plugins: [
        laravel({
            input: [
                ...cssFiles,
                ...jsFiles,
            ],
            refresh: true,
        }),
    ],
});
