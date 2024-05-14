import BlogTable from './components/BlogTable.vue';
import BlogForm from './components/BlogForm.vue';

const { locales } = window.AsgardCMS;

export default [
    {
        path: '/blog/blogs',
        name: 'admin.blog.blog.index',
        component: BlogTable,
    },
    {
        path: '/blog/blogs/create',
        name: 'admin.blog.blog.create',
        component: BlogForm,
        props: {
            locales,
            blogTitle: 'create blog',
        },
    },
    {
        path: '/blog/blogs/:blogId/edit',
        name: 'admin.blog.blog.edit',
        component: BlogForm,
        props: {
            locales,
            blogTitle: 'edit blog',
        },
    },
];
