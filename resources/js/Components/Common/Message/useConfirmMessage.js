import {defineStore} from "pinia";

export const ConfirmMessage = defineStore('confirmMessage', {
    state: () => ({
        isShow: false,
        message: 'This is a confirm message',
        title: 'Are you sure?',
        isConfirm: false,
    }),
    actions: {
        confirm(message) {
            this.isShow = true;
            this.message = message;
            return new Promise((resolve, reject) => {
                this.resolve = resolve;
                this.reject = reject;
            });
        },
        handleConfirmation(choice) {
            this.isShow = false;
            if (choice) {
                this.isConfirm = true;
                this.resolve();
            } else {
                this.isConfirm = false;
                this.reject();
            }
        },
        resetState() {
            // Reset the store's state
            this.isShow = false;
            this.message = 'This is a confirm message';
            this.title = 'Are you sure?';
            this.isConfirm = false;
            this.resolve = null;
            this.reject = null;
        }
    },
    afterAction(_, __, ___, actionName) {
        if (actionName !== 'resetState') {
            console.log('sssssss')
            this.resetState();
        }
    }
});
