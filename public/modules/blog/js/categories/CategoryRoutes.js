import CategoryTable from './components/CategoryTable.vue';
import CategoryForm from './components/CategoryForm.vue';

const { locales } = window.AsgardCMS;

export default [
    {
        path: '/blog/categories',
        name: 'admin.blog.category.index',
        component: CategoryTable,
    },
    {
        path: '/blog/categories/create',
        name: 'admin.blog.category.create',
        component: CategoryForm,
        props: {
            locales,
            blogTitle: 'create category',
        },
    },
    {
        path: '/blog/categories/:categoryId/edit',
        name: 'admin.blog.category.edit',
        component: CategoryForm,
        props: {
            locales,
            blogTitle: 'edit category',
        },
    },
];
