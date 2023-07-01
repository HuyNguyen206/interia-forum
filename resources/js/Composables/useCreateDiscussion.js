import {ref} from "vue";
import {useForm} from "@inertiajs/vue3";


const visible = ref(true)

export default () => {
    const showCreateDiscussionForm = () => {
        visible.value = true
    }

    const hideCreateDiscussionForm = () => {
        visible.value = false
    }

    const toggleCreateDiscussionForm = () => {
        visible.value = !visible.value
    }

    const form = useForm({
        topic_id: '',
        title: '',
        body: ''
    })

    return {
        visible, showCreateDiscussionForm, hideCreateDiscussionForm, toggleCreateDiscussionForm, form
    }
}
