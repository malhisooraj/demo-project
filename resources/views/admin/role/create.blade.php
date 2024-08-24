<x-layout>
    <section class="py-8 max-w-4xl mx-auto">
        <h1 class="text-lg font-bold mb-8 pb-2 border-b">
            Add Admin Role
        </h1>

        <div class="flex">
            <aside class="w-48 flex-shrink-0">
                <h4 class="font-semibold mb-4">Links</h4>

                <ul>
                    <li>
                        <a href="/admin/roles" class="{{ request()->is('admin/roles') ? 'text-blue-500' : '' }}">All Roles</a>
                    </li>

                    <li>
                        <a href="/admin/roles/create" class="{{ request()->is('admin/roles/create') ? 'text-blue-500' : '' }}">New Role</a>
                    </li>
                </ul>
            </aside>

            <main class="flex-1">
                <div class="border border-gray-200 p-6 rounded-xl">
                    <form method="POST" action="/admin/roles">
                        @csrf

                        <x-form.input name="role" required />

                        <x-form.field>
                            <x-form.label name="permissions"/>

                            <select name="permissions[]" id="permissions" required multiple>
                                <option value="all" {{ old('all') }}>All</option>
                                <option value="edit" {{ old('edit') }}>Edit</option>
                                <option value="update" {{ old('publish') }}>Publish</option>
                                <option value="unpublish" {{ old('unpublish') }}>Unpublish</option>
                                <option value="delete" {{ old('delete') }}>Delete</option>
                            </select>

                            <x-form.error name="permissions"/>
                        </x-form.field>

                        <x-form.button>Submit</x-form.button>
                    </form>
                </div>
            </main>
        </div>
    </section>
</x-layout>
