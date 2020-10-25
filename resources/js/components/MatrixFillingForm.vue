<template>
    <div>
        <div v-if="matrix_size_1 && matrix_size_1">
            <div class="text-center">
                <button class="btn btn-dark" @click="fillRandomly">Fill both matrices with random numbers</button>
            </div>
            <h4 class="text-center mt-4">Fill in Matrix 1</h4>
            <matrix :size="matrix_size_1" @UPDATE_MATRIX="updateMatrix($event, 1)"></matrix>

            <h4 class="text-center mt-4">Fill in Matrix 2</h4>
            <matrix :size="matrix_size_2" @UPDATE_MATRIX="updateMatrix($event, 2)"></matrix>
            <div class="text-center p-5">
                <button 
                    class="btn btn-dark" 
                    @click="multiplyMatrices"
                    :disabled="disabled"
                >
                    calculate now
                    <b-spinner v-if="disabled"></b-spinner>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import EventBus from '@/EventBus';
    import Matrix from './MatrixComponent';

    export default {
        data() {
            return {
                matrix_1: null,
                matrix_2: null,
                disabled: false
            }
        },
        props: ['matrix_size_1', 'matrix_size_2'],
        components: {
            Matrix
        },
        methods: {
            fillRandomly() {
                EventBus.$emit('FILL_INPUTS_RANDOMLY');
            },
            updateMatrix(new_matrix, which_matrix) {
                if (which_matrix == 1) {
                    this.matrix_1 = new_matrix;
                } else if (which_matrix == 2) {
                    this.matrix_2 = new_matrix;
                }
            },
            multiplyMatrices() {
                this.disabled = true;
                let number_pattern = /^(-|\+)?[0-9]+(\.[0-9]+)?$/;

                if(!this.matrix_1 || !this.matrix_2){
                    EventBus.$emit('VALIDATE_MATRIX_ITEMS');
                    this.disabled = false;
                    this.$bvToast.toast('Please fill in all inputs within every matrix', {
                        variant: 'danger',
                        title: 'Error!'
                    });

                    return false;
                }

                for(let i = 0; i < this.matrix_size_1.rows; i++) {
                    for (let j = 0; j < this.matrix_size_1.columns; j++) {
                        if(!number_pattern.test(this.matrix_1[i][j])){
                            EventBus.$emit('VALIDATE_MATRIX_ITEMS');
                            this.disabled = false;
                            this.$bvToast.toast('Please fill in all inputs within every matrix', {
                                variant: 'danger',
                                title: 'Error!'
                            });
                            
                            return false;
                        }
                    }
                }

                for(let i = 0; i < this.matrix_size_2.rows; i++) {
                    for (let j = 0; j < this.matrix_size_2.columns; j++) {
                        if(!number_pattern.test(this.matrix_2[i][j])){
                            EventBus.$emit('VALIDATE_MATRIX_ITEMS');
                            this.disabled = false;
                            this.$bvToast.toast('Please fill in all inputs within every matrix', {
                                variant: 'danger',
                                title: 'Error!'
                            });
                            
                            return false;
                        }
                    }
                }

                let data = {
                    matrix_1: this.matrix_1,
                    matrix_2: this.matrix_2,
                };
                
                this.$http.post(
                    '/api/multiply-matrix',
                    data
                ).then(response => {
                    this.$emit('RETURN_MATRIX_RESULT', response.data);
                }).catch(err => {
                    let error = err.response.data.message;
                    this.$bvToast.toast(error, {
                        variant: 'danger',
                        title: 'Error'
                    });
                }).finally(() => {
                    this.disabled = false;
                });
            }
        },
        mounted(){
            this.$nextTick(() => {
                EventBus.$emit('END_LOADING');
            });
        },
    }
</script>

<style lang="scss" scoped>

</style>