import {router} from "@inertiajs/vue3";
import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import {ConfirmMessage} from "@/Components/Common/Message/useConfirmMessage.js";

const toast = useToast({
    position:"top-right",
    queue: true
});
export function useCrud(id) {

    const submitForm = (form, submit_link, back_link = null,preserveScroll = null,preserveState = null,has_file = false) => {
        return new Promise((resolve, reject) => {
            if (form.id) {
                if(has_file){
                    form['_method'] = "PUT"
                    form.post(route(submit_link, form.id), {
                        preserveScroll: preserveScroll,
                        preserveState : preserveState,
                        onSuccess: () => {
                            toast.success('Record successfully saved')
                            if (back_link) {
                                router.visit(back_link);
                            }

                            resolve('Success')

                        },
                        onError: () => {
                            toast.error('Oops, something went wrong')
                            reject('Error')
                        }
                    })
                }
                else{
                    form.patch(route(submit_link, form.id), {
                        preserveScroll: preserveScroll,
                        preserveState : preserveState,
                        onSuccess: () => {
                            toast.success('Record successfully saved')
                            if (back_link) {
                                router.visit(back_link);
                            }

                            resolve('Success')

                        },
                        onError: () => {
                            toast.error('Oops, something went wrong')
                            reject('Error')
                        }
                    })
                }

            } else {
                form.post(route(submit_link), {
                    preserveScroll: preserveScroll,
                    preserveState : preserveState,
                    onSuccess: () => {

                        form.reset()
                        if (back_link) {
                            router.visit(back_link);
                        }
                        toast.success('Record successfully saved')
                        resolve('Success')
                    },
                    onError: () => {
                        toast.error('Oops, something went wrong')
                        reject('Error')
                    }
                })
            }
        });
    }

    const destroy = (destroy_link) => {
        ConfirmMessage().confirm('You are about to delete the current record. Continue?')
            .then(() => {
                router.delete(destroy_link, {
                    onSuccess: () => {
                        toast.success('Record successfully deleted')
                    },
                    onError: () => {
                        toast.error('Oops, something went wrong')
                    }
                })
            }).catch(()=>{
        })

    }
    const update_status = (update_link) => {
        ElMessageBox.confirm(
            'You will update the status of this record. Continue?',
            'Info',
            {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'info',
            }
        )
            .then(() => {
                router.post(update_link, {
                    onSuccess: () => {
                        toast.success('Record successfully saved')
                    },
                    onError: () => {
                        toast.error('Oops, something went wrong')
                    }
                })
            })
            .catch(() => {
                ElMessage({
                    type: 'info',
                    message: 'Update Canceled',
                })
            })
    }
    return {
        submitForm,
        destroy,
        update_status,
    }
}
