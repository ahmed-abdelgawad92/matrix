<template>
    <div v-if="show">
        <form @submit.prevent="createMatrices" class="mt-5">
            <h4 class="mt-4 text-center">Matrix 1</h4>
            <div class="row justify-content-md-center">
                <div class="col-3">
                    <label>Number of rows</label>
                    <b-form-input 
                        v-model="num_of_rows_1" 
                        :state="error_states.rows_1.state" 
                        placeholder="Enter number of rows"
                    ></b-form-input>
                    <b-form-invalid-feedback>
                        {{error_states.rows_1.msg ? error_states.rows_1.msg : ''}}
                    </b-form-invalid-feedback>
                </div>
                <div class="col-3">
                    <label>Number of columns</label>
                    <b-form-input 
                        v-model="num_of_columns_1" 
                        :state="error_states.columns_1.state" 
                        placeholder="Enter number of columns"
                    ></b-form-input>
                    <b-form-invalid-feedback>
                        {{error_states.columns_1.msg ? error_states.columns_1.msg : ''}}
                    </b-form-invalid-feedback>
                </div>
            </div>
            <h4 class="mt-4 text-center">Matrix 2</h4>
            <div class="row justify-content-md-center">
                <div class="col-3">
                    <label>Number of rows</label>
                    <b-form-input 
                        v-model="num_of_rows_2" 
                        :state="error_states.rows_2.state" 
                        placeholder="Enter number of rows"
                    ></b-form-input>
                    <b-form-invalid-feedback>
                        {{error_states.rows_2.msg ? error_states.rows_2.msg : ''}}
                    </b-form-invalid-feedback>
                </div>
                <div class="col-3">
                    <label>Number of columns</label>
                    <b-form-input 
                        v-model="num_of_columns_2" 
                        :state="error_states.columns_2.state" 
                        placeholder="Enter number of columns"
                    ></b-form-input>
                    <b-form-invalid-feedback>
                        {{error_states.columns_2.msg ? error_states.columns_2.msg : ''}}
                    </b-form-invalid-feedback>
                </div>
            </div>
            <div class="mt-4 text-center">
                <button 
                    class="btn btn-lg btn-outline-secondary" 
                    @click="resetForm"
                    type="button"
                >reset</button>
                <button class="btn btn-lg btn-dark" type="submit">submit</button>
            </div>
        </form>
    </div>
</template>

<script>
    import EventBus from '@/EventBus';

    export default {
        data() {
            return {
                show: true,
                num_of_rows_1: null,
                num_of_columns_1: null,
                num_of_rows_2: null,
                num_of_columns_2: null,
                error_msgs: {
                    required: 'This field is mandatory',
                    number: 'This field must be a whole number',
                    match: 'The number of columns in Matrix 1 must match the number of rows in Matrix 2'
                },
                error_states: {
                    rows_1: {
                        state: null
                    },
                    columns_1: {
                        state: null
                    },
                    rows_2: {
                        state: null
                    },
                    columns_2: {
                        state: null
                    }
                }
            }
        },
        methods: {
            createMatrices() {
                let valid = this.validate();
                if (valid){
                    let matrices = {
                        matrix_1: {
                            rows: this.num_of_rows_1,
                            columns: this.num_of_columns_1
                        },
                        matrix_2: {
                            rows: this.num_of_rows_2,
                            columns: this.num_of_columns_2
                        }
                    }
                    EventBus.$emit('START_LOADING');
                    this.show = false;
                    setTimeout(() => {
                        EventBus.$emit('MATRIX_SIZE_DECLARED', matrices);
                    }, 100);
                }
            },
            validate() {
                //reset error states
                this.error_states = {
                    rows_1: {
                        state: null
                    },
                    columns_1: {
                        state: null
                    },
                    rows_2: {
                        state: null
                    },
                    columns_2: {
                        state: null
                    }
                };

                let check_row_1 = this.validateInput(this.num_of_rows_1, this.error_states.rows_1);
                let check_column_1 = this.validateInput(this.num_of_columns_1, this.error_states.columns_1);
                let check_row_2 = this.validateInput(this.num_of_rows_2, this.error_states.rows_2);
                let check_column_2 = this.validateInput(this.num_of_columns_2, this.error_states.columns_2);
                
                if (
                    !check_row_1 ||
                    !check_column_1 ||
                    !check_row_1 ||
                    !check_column_2
                ) {
                    return false;
                } else if (this.num_of_columns_1 != this.num_of_rows_2) {
                    this.error_states.columns_1.state = false;
                    this.error_states.columns_1.msg = this.error_msgs.match;
                    this.error_states.rows_2.state = false;
                    this.error_states.rows_2.msg = this.error_msgs.match;

                    return false;
                }

                return true;
            },
            validateInput(input_value, error_state) {
                let num_regex = /^[0-9]+$/;

                if (!input_value) {                    
                    error_state.state = false;
                    error_state.msg = this.error_msgs.required;
                    
                    return false;
                } else if (!num_regex.test(input_value)) {                    
                    error_state.state = false;
                    error_state.msg = this.error_msgs.number;
                    
                    return false;
                } else {
                    error_state.state = true;
                }

                return true;
            },
            resetForm() {
                this.error_states = {
                    rows_1: {
                        state: null
                    },
                    columns_1: {
                        state: null
                    },
                    rows_2: {
                        state: null
                    },
                    columns_2: {
                        state: null
                    }
                };
                
                this.show = true;
                this.num_of_rows_1 = null;
                this.num_of_columns_1 = null;
                this.num_of_rows_2 = null;
                this.num_of_columns_2 = null;
            }
        },
        created() {
            EventBus.$on('NEW_CALCULATION', this.resetForm);
        },
        destroyed() {
            EventBus.$off('NEW_CALCULATION', this.resetForm);
        }
    }
</script>

<style lang="scss" scoped>
.btn {
    width: 140px;
}
</style>