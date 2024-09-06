const navigation = [
    {
        label: 'Dashboard',
        icon: 'bi bi-columns-gap',
        route: 'dashboard',
        base_route: 'dashboard',
        access: ['Admin', 'Super Admin', 'User']
    },
    {
        label: 'Document',
        icon: 'bi bi-files',
        route: 'admin.documents.index',
        base_route: 'admin.documents.*',
        access: ['Admin', 'Super Admin', 'User']
    },
    {
        label: 'Task',
        icon: 'bi bi-card-checklist',
        route: 'admin.tasks.index',
        base_route: 'admin.tasks.*',
        access: ['Admin', 'Super Admin', 'User']
    },
    {
        label: 'Case',
        icon: 'bi bi-folder2',
        route: 'admin.cases.index',
        base_route: 'admin.cases.*',
        access: ['Admin', 'Super Admin', 'User']
    },
    {
        label: 'Event',
        icon: 'bi bi-calendar2-week',
        route: 'admin.events.index',
        base_route: 'admin.events.*',
        access: ['Admin', 'Super Admin', 'User']
    },
    {
        label: 'Rank',
        icon: 'bi bi-trophy',
        route: 'admin.ranks.index',
        base_route: 'admin.ranks.*',
        access: ['Admin', 'Super Admin']
    },
    {
        label: 'Chat',
        icon: 'bi bi-messenger',
        route: 'admin.chats.index',
        base_route: 'admin.chats.*',
        access: ['Admin', 'Super Admin','User']
    },
    {
        label: 'Users',
        icon: 'bi bi-people',
        route: 'admin.users.index',
        base_route: 'admin.users.*',
        access: [ 'Super Admin','Admin']
    },
    {
        label: 'My Profile',
        icon: 'bi bi-lock',
        route: 'profile.edit',
        base_route: 'profile.*',
    },

]

const userNavigation = [
    {name: 'My Profile', href: '/profile'},
    {name: 'Sign out', href: '/logout',method: 'post'},
]

export {navigation, userNavigation}
