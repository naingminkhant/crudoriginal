
var E_SERVER_ERROR = 'Error communicating with the server';

// fields definition
var tableColumns = [
    {
        name: 'id',
        sortField: 'id'
    },
    {
        name: 'name',
        sortField: 'name'
    },
    {
        name: 'title',
        sortField: 'title'
    },
    {
        name: 'description',
        sortField: 'description'
    },
    {
        name: '__actions',
        dataClass: 'text-center'
    }
];

Vue.config.debug = true;

var vm = new Vue({
    el: '#CategoryController',
    data: {
        query: '',
        modal:false,
        newCategory: {
            id:'',
            title: '',
            name: '',
            description: ''
        },
        // notife remove data
        remove: false,
        // notife edit data
        succ:false,
        edit:false,
        // notife add data
        success: false,

        // Vue Table Section
        searchFor: '',
        fields: tableColumns,
        sortOrder: [{
            field: 'id',
            direction: 'asc'
        }],
        perPage: 10,
        paginationComponent: 'vuetable-pagination',
        paginationInfoTemplate: 'Something',
        itemActions: [
            { name: 'edit-item', label: '', icon: 'glyphicon glyphicon-pencil', class: 'btn btn-warning', extra: {title: 'Edit', 'data-toggle':"modal", 'data-target':"#myModal", 'data-placement': "top"} },
            { name: 'delete-item', label: '', icon: 'glyphicon glyphicon-remove', class: 'btn btn-danger', extra: {title: 'Delete', 'data-toggle':"tooltip", 'data-placement': "right" } }
        ],
        moreParams: []
    },

    watch: {
        'perPage': function(val, oldVal) {
            this.$broadcast('vuetable:refresh')
        },
        'paginationComponent': function(val, oldVal) {
            this.$broadcast('vuetable:load-success', this.$refs.vuetable.tablePagination);
            this.paginationConfig(this.paginationComponent)
        }
    },

    methods: {
        RemoveCategory: function (id, name) {
            swal({
                title: "Are you sure?",
                text: "Are you sure that you want to delete \""+name+"\" ?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                confirmButtonText: "Yes, delete it!",
                confirmButtonColor: "#ec6c62"
            }, function(isConfirm) {
                if(isConfirm) {
                    Vue.http.delete("/api/category/"+id);
                    vm.$broadcast('vuetable:reload');
                    swal("Successfully!", "\""+name+"\" is successfully deleted!", "success");
                }
                else
                {
                    swal('Oops', E_SERVER_ERROR, 'error');
                }
            });
        },

        EditCategory: function (id) {
            var category = this.newCategory;
            this.newTag = {id: '', name: '', title: '', description: ''};

            this.$http.patch('api/category/' + id, category, function (data) {
                console.log(data)
            });

            self = this;
            this.succ=true;
            setTimeout(function () {
                self.succ = false
            }, 1000);
            this.$broadcast('vuetable:reload');
            this.edit = false;

            $('#myModal').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();

        },

        ShowCategory: function (id) {
            this.edit = true;
            this.$http.get('/api/category/' + id, function (data) {
                vm.newCategory.id = data.id;
                vm.newCategory.title = data.title;
                vm.newCategory.name = data.name;
                vm.newCategory.description = data.description;
            });
        },

        AddNewUser: function () {
            $('#myModal').on('hidden', function() {
                $(this).data('modal').$element.removeData();
            })
            //INPUT
            var category = this.newCategory;
            this.newCategory = {id:'', title: '', name: '', description: ''};
            this.$http.post('/api/category/', category);
            // show success message
            self = this;
            this.success = true;
            setTimeout(function () {
                self.success = false
            }, 1000);
            //reload page
            this.$broadcast('vuetable:reload');

            $('#myModal').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        },
        /**
         * Callback functions
         */
        formatDate: function(value, fmt) {
            if (value == null) return '';
            fmt = (typeof fmt == 'undefined') ? 'D MMM YYYY' : fmt;
            return moment(value, 'YYYY-MM-DD').format(fmt)
        },
        /**
         * Other functions
         */
        setFilter: function() {
            this.moreParams = [
                'filter=' + this.searchFor
            ];
            this.$nextTick(function() {
                this.$broadcast('vuetable:refresh');
            })
        },
        resetFilter: function() {
            this.searchFor = '';
            this.setFilter();
        },
        preg_quote: function( str ) {
            return (str+'').replace(/([\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:])/g, "\\$1");
        },
        highlight: function(needle, haystack) {
            return haystack.replace(
                new RegExp('(' + this.preg_quote(needle) + ')', 'ig'),
                '<span class="highlight">$1</span>'
            )
        },
        rowClassCB: function(data, index) {
            return (index % 2) === 0 ? 'positive' : ''
        },
        paginationConfig: function(componentName) {
            console.log('paginationConfig: ', componentName)
            if (componentName == 'vuetable-pagination') {
                this.$broadcast('vuetable-pagination:set-options', {
                    wrapperClass: 'pagination',
                    icons: { first: '', prev: '', next: '', last: ''},
                    activeClass: 'active',
                    linkClass: 'btn btn-default',
                    pageClass: 'btn btn-default'
                })
            }
            if (componentName == 'vuetable-pagination-dropdown') {
                this.$broadcast('vuetable-pagination:set-options', {
                    wrapperClass: 'form-inline',
                    icons: { prev: 'glyphicon glyphicon-chevron-left', next: 'glyphicon glyphicon-chevron-right' },
                    dropdownClass: 'form-control'
                });
            }
        }
    },

    events: {
        'vuetable:row-changed': function(data) {
            console.log('row-changed:', data.name);
        },
        'vuetable:row-clicked': function(data, event) {
            console.log('clicked:', data.name)
            this.$broadcast('vuetable:toggle-detail', data.id)
        },
        'vuetable:action': function(action, data) {
            console.log('vuetable:action', action, data)
            if (action == 'edit-item') {
                this.ShowCategory(data.id);
            } else if (action == 'delete-item') {
                this.RemoveCategory(data.id,data.name);
            }
        },
        'vuetable:load-success': function(response) {
            console.log('load-success');
        },
        'vuetable:load-error': function(response) {
            if (response.status == 400) {
                sweetAlert('Something\'s Wrong!', response.data.message, 'error')
            } else {
                sweetAlert('Oops', E_SERVER_ERROR, 'error')
            }
        }
    },

    computed: {
        validation: function () {
            return {
                title: !!this.newCategory.title.trim(),
                name: !!this.newCategory.name.trim(),
                description: !!this.newCategory.description.trim(),
            }
        },
        isValid: function () {
            var validation = this.validation;
            return Object.keys(validation).every(function (key) {
                return validation[key]
            })
        }
    }
});