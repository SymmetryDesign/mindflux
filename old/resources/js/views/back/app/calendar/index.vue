<template>
    <v-app-default-layout>
        <template v-slot:header>
            <div class="mr-6">
                <div class="flex items-center">
                    <button @click="calendar.today()" class="btn btn-sm btn-white" type="button">
                        {{ $trans('labels.today') }}
                    </button>

                    <div class="btn-group ml-3">
                        <button @click="calendar.prev()" class="btn btn-white" type="button">
                            <svg class="w-4 h-4" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.05 9.293L6.343 10 12 15.657l1.414-1.414L9.172 10l4.242-4.243L12 4.343z"/>
                            </svg>
                        </button>

                        <button @click="calendar.next()" class="btn btn-white" type="button">
                            <svg class="w-4 h-4" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.95 10.707l.707-.707L8 4.343 6.586 5.757 10.828 10l-4.242 4.243L8 15.657l4.95-4.95z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <h1 class="text-lg font-semibold ml-3 sm:ml-0">{{ currentDate }}</h1>
        </template>

        <div class="px-8 mt-4" v-if="$page.errors.has('plan.limit')">
            <v-alert variant="warning" show>
                {{ $page.errors.first('plan.limit') }}
            </v-alert>
        </div>

        <template>
            <div class="flex flex-1 flex-col m-4 sm:m-6 lg:m-8">
                <v-full-calendar
                    class="bg-white shadow-sm"
                    :dates-render="onDatesRender"
                    :display-event-time="false"
                    :editable="true"
                    :events="$page.events"
                    :header="false"
                    :plugins="calendarPlugins"
                    @eventClick="onEventClick($event.event)"
                    @eventDrop="onEventDrop($event.event)"
                    default-view="dayGridMonth"
                    height="parent"
                    ref="calendar"
                />
            </div>
        </template>
    </v-app-default-layout>
</template>

<script>
    import VAppDefaultLayout from '@/views/back/app/layouts/default'
    import VFullCalendar from '@fullcalendar/vue'
    import interactionPlugin from '@fullcalendar/interaction';
    import dayGridPlugin from '@fullcalendar/daygrid'
    import VTaskModal from '@/views/back/app/tasks/modal-task'
    import VAlert from '@/components/alert'

    export default {
        metaInfo() {
            return {
                title: this.$trans('headings.calendar')
            }
        },

        components: {
            VAppDefaultLayout,
            VFullCalendar,
            VAlert
        },

        props: {
            users: {
                type: Array,
                required: true
            }
        },

        data() {
            return {
                calendar: null,
                currentDate: '',
                calendarPlugins: [
                    dayGridPlugin, interactionPlugin
                ]
            }
        },

        mounted() {
            this.calendar = this.$refs.calendar.getApi();
        },

        methods: {
            onEventClick(event) {
                this.$modal(VTaskModal, {
                    users: this.users,
                    projectUuid: event.extendedProps.project_uuid,
                    taskUuid: event.extendedProps.uuid,
                    content: event.title,
                    isCompleted: event.extendedProps.is_completed,
                    dueDate: moment(event.start).format('YYYY-MM-DD'),
                    userUuid: event.extendedProps.user_uuid,
                    priority: event.extendedProps.priority
                });
            },
            onEventDrop(event) {
                this.$inertia
                    .put(route('app:project.tasks.update', {
                        project: event.extendedProps.project_uuid,
                        task: event.extendedProps.uuid,
                    }), {
                        'content': event.title,
                        'due_date': moment(event.start).format('YYYY-MM-DD'),
                        'is_completed': event.extendedProps.is_completed,
                        'user_uuid': event.extendedProps.user_uuid,
                        'priority': event.extendedProps.priority,
                    });
            },
            onDatesRender() {
                this.$nextTick(() => {
                    this.currentDate = moment(this.calendar.getDate()).format('MMMM YYYY');
                });
            }
        }
    }
</script>
