import TrenchDevsAdminLayout from "@/Themes/TrenchDevsAdmin/Layouts/TrenchDevsAdminLayout";
import {Link, useForm, usePage} from "@inertiajs/inertia-react";
import * as Icon from 'react-feather';
import slugify from "slugify";
import {useEffect} from "react";
import MarkdownEditor from "@/Themes/TrenchDevsAdmin/Components/Forms/MarkdownEditor";

export default function BlogUpsert() {

    const {blog, errors = {}} = usePage().props;
    const form = useForm({
        status: 'draft',
        title: '',
        ...blog
    })

    function submitForm(e) {
        e.preventDefault();
        form.post('/dashboard/blogs/upsert');
    }

    useEffect(() => {

        if (form.data.title) {
            form.setData('slug', slugify(form.data.title).toLowerCase())
        }
    }, [form.data.title]);

    return (

        <TrenchDevsAdminLayout>
            <div className="card">
                <div className="card-header">{form.data.id ? 'Update' : 'Create'} Content</div>
                <div className="card-body">

                    <form onSubmit={submitForm}>
                        <div className="form-group">
                            <label htmlFor="title">Title</label>
                            <input
                                id="slug"
                                className="form-control"
                                type="text"
                                name="title"
                                onChange={e => {
                                    form.setData(e.target.name, e.target.value);
                                }}
                                value={form.data.title}
                            />
                            {errors.title && <div className="text-danger">{errors.title}</div>}
                        </div>

                        <div className="form-group">
                            <label htmlFor="slug">Slug</label>
                            <input
                                id="slug"
                                className="form-control"
                                type="text"
                                name="slug"
                                onChange={e => form.setData(e.target.name, e.target.value)}
                                value={form.data.slug}
                            />
                            {errors.slug && <div className="text-danger">{errors.slug}</div>}
                        </div>

                        <div className="form-group">
                            <label htmlFor="tagline">Tagline</label>
                            <textarea
                                name="tagline"
                                id="tagline"
                                cols="30"
                                rows="2"
                                className="form-control"
                                onChange={e => form.setData(e.target.name, e.target.value)}
                                value={form.data.tagline}
                            />
                            {errors.tagline && <div className="text-danger">{errors.tagline}</div>}
                        </div>

                        <div>
                            <label htmlFor="markdown_contents">Body</label>
                            <MarkdownEditor value={form.data.markdown_contents} onChange={(html, text) => form.setData('markdown_contents', text)}/>
                            {errors.markdown_contents && <div className="text-danger">{errors.markdown_contents}</div>}
                        </div>

                        <div className="form-group">
                            <label htmlFor="primary_image_url">
                                Primary Image URL <small>(shown on the blog listing and below title and tagline on
                                blog details)
                            </small>
                            </label>
                            <p>Tip: you can try using the unsplash to get free images <br/> (eg.
                                <strong>https://source.unsplash.com/1024x760/?blog,blogs,book</strong> - This will
                                return a url
                                to get pictures with blog / books tagged in
                                them)
                            </p>
                            <input
                                type="text"
                                name="primary_image_url"
                                id="primary_image_url"
                                className="form-control"
                                onChange={e => form.setData(e.target.name, e.target.value)}
                                value={form.data.primary_image_url}
                            />
                            {errors.primary_image_url && <div className="text-danger">{errors.primary_image_url}</div>}

                        </div>

                        <div className="form-group">
                            <label htmlFor="publication_date">
                                Publication Date (when will the blog post be available to the public)
                                <em>eg: 2020-09-25 15:03:00</em>
                            </label>
                            <input
                                type="text"
                                name="publication_date"
                                className="form-control"
                                placeholder="YYYY-mm-dd HH:mm:ss"
                                onChange={e => form.setData(e.target.name, e.target.value)}
                                value={form.data.publication_date}
                            />
                            {errors.publication_date && <div className="text-danger">{errors.publication_date}</div>}
                        </div>

                        <div className="form-group">
                            <label htmlFor="tags">Tags (comma-separated) - eg. <em>"laravel, codeigniter,
                                nodejs"</em></label>
                            <textarea
                                name="tags"
                                id="tags"
                                cols="30"
                                rows="2"
                                className="form-control"
                                onChange={e => form.setData(e.target.name, e.target.value)}
                                value={form.data.tags}
                            />
                            {errors.tags && <div className="text-danger">{errors.tags}</div>}
                        </div>

                        <div className="form-group">
                            <label htmlFor="status">Status</label>
                            <select
                                className="form-control"
                                name="status" id="status"
                                onChange={e => form.setData(e.target.name, e.target.value)}
                                value={form.data.status}
                            >
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                            </select>
                            {errors.status && <div className="text-danger">{errors.status}</div>}
                        </div>

                        <div className="text-right">
                            <Link className="btn btn-warning mr-2" href="/dashboard/blogs">
                                <Icon.SkipBack size={14}/>
                                <span className="ml-2">Cancel</span>
                            </Link>
                            <button className="btn btn-success">
                                <Icon.Save size={14}/>
                                <span className="ml-1"> Save</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </TrenchDevsAdminLayout>
    );
}
