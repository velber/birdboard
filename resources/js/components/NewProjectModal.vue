<template>
    <modal name="new-project" classes="p-10 bg-card rounded-lg" height="auto">
        <form @submit.prevent="submit">
            <h1 class="font-normal mb-16 text-center text-2xl">Create project</h1>
            <div class="flex">
                <div class="flex-1 mr-4">
                    <div class="mb-4">
                        <label for="title" class="text-sm block mb-2">Title</label>
                        <input type="text"
                               id="title"
                               class="border border-muted-light p-2 text-xs block w-full rounded"
                               :class="errors.title ? 'border-error' : 'border-muted-light'"
                               v-model="form.title">
                        <span class="text-xs italic text-error" v-if="errors.title" v-text="errors.title[0]"></span>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="text-sm block mb-2">Description</label>
                        <textarea type="description" id="description" class="border border-muted-light p-2 text-xs block w-full rounded" rows="7"
                                  v-model="form.description"
                        ></textarea>
                        <span class="text-xs italic text-error" v-if="errors.description" v-text="errors.description[0]"></span>
                    </div>
                </div>
                <div class="flex-1 ml-4">
                    <div class="mb-4">
                        <label for="title" class="text-sm block mb-2">Need new?</label>
                        <input type="text"
                               class="border border-muted-light mb-2 p-2 text-xs block w-full rounded"
                               placeholder="Task 1"
                               v-for="task in form.tasks"
                               v-model="task.value">
                    </div>
                    <button class="inline-flex items-center text-xs" @click="addTask">
                        <span>Add New Task Field</span>
                    </button>
                </div>
            </div>
            <footer class="flex justify-end">
                <button class="button mr-3 is-outlined" @click="$modal.hide('new-project')">Cancel</button>
                <button type="submit" class="button">Create Project</button>
            </footer>
        </form>
    </modal>
</template>

<script>
    export default {
        data() {
            return {
                form : {
                    title: '',
                    description: '',
                    tasks: [
                        { value: ''}
                    ]
                },
                errors: {}
            }
        },
        methods: {
            addTask() {
                this.form.tasks.push({value: ''})
            },
            async submit() {
                try {
                    location = (await axios.post('/projects', this.form)).data.message;
                } catch (error) {
                    this.errors = error.response.data.errors;
                }
            }
        }
    }
</script>
