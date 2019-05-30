<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Users</div>

                    <div class="card-body">
                        <vue-good-table
                                mode="remote"
                                :columns="columns"
                                :rows="rows"
                                :globalSearch="true"
                                :search-options="{
                                enabled: true,
                                skipDiacritics: true,
                             }"
                                @on-search="onSearch"
                                styleClass="table table-hover table-bordered table-responsive">
                            <template slot="table-row" slot-scope="props">
                        <span v-if="props.column.field === 'S.No'">

                         {{ (users.per_page * (users.current_page - 1)) + (props.index + 1)
                          }}
                        </span>
                                <span v-else>
                    {{props.formattedRow[props.column.field]}}
                  </span>
                            </template>
                        </vue-good-table>
                        <vue-pagination :pagination="users"
                                        @paginate="getRecords()"
                                        :offset="4">
                        </vue-pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import VueGoodTable from 'vue-good-table';
    import VuePagination from './Paginator';
    // import the styles
    import 'vue-good-table/dist/vue-good-table.css'

    Vue.use(VueGoodTable);
    export default {
        props: ['endpoint'],
        data() {
            return {
                users: {
                    searchTerm: '',
                    total: 0,
                    per_page: 5,
                    from: 1,
                    to: 0,
                    current_page: 1
                },
                offset: 4,
                columns: [
                    {
                        label: 'S.No',
                        field: 'S.No'
                    },
                    {
                        label: 'User Name',
                        field: 'name',
                        filterable: true
                    },
                    {
                        label: 'Email Address',
                        field: 'email',
                        filterable: true
                    },
                    {
                        label: 'Created At',
                        field: 'created_at',
                        filterable: true
                    },
//
                ],
                rows: []
            }
        },
        components: {
            VuePagination,
        },

        mounted() {
            this.getRecords()
        },
        methods: {

            getRecords() {
                return axios.get(`${this.endpoint}?searchTerm=${this.users.searchTerm}&page=${this.users.current_page}&per_page=${this.users.per_page}`).then((response) => {
                    this.rows = response.data.users.data
                    this.users = response.data.users
                })
            },
            updateParams(newProps) {
                this.users = Object.assign({}, this.users, newProps);
            },
            onSearch: _.debounce(function (params) {
                this.updateParams(params);
                this.getRecords();
                return false;
            }, 500)
        }
    }
</script>