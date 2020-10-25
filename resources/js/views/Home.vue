<template>
    <div class="container mt-3">
        <h1 class="text-center">Matrix Multiplication</h1>
        <div class="text-center mt-5" v-if="loading">
            <b-spinner style="width: 5rem; height: 5rem;" label="Loading..."></b-spinner>
        </div>
        <matrix-declaring-form />
        <div v-if="matrix_size_1 && matrix_size_1 && !matrix_result">
            <matrix-filling-form 
                :matrix_size_1="matrix_size_1" 
                :matrix_size_2="matrix_size_2"
                @RETURN_MATRIX_RESULT="getResult"
            />
        </div>
        <div v-if="matrix_result">
            <matrix-result :matrices="matrix_result"></matrix-result>
        </div>
    </div>
</template>

<script>
    import EventBus from '@/EventBus';
    import MatrixDeclaringForm from '@/components/MatrixDeclaringForm';
    import MatrixFillingForm from '@/components/MatrixFillingForm';
    import MatrixResult from '@/components/MatrixResult';

    export default {
        data() {
            return {
                loading: false,
                matrix_size_1: null,
                matrix_size_2: null,
                matrix_result: null,
            }
        },
        components: {
            MatrixDeclaringForm,
            MatrixFillingForm,
            MatrixResult,
        },
        methods: {
            assignMatrixSize(matrices_size) {
                this.matrix_size_1 = matrices_size.matrix_1;
                this.matrix_size_2 = matrices_size.matrix_2;
            },
            getResult(matrix) {
                this.matrix_result = matrix;
            },
            resetForm() {
                this.matrix_size_1 = null;
                this.matrix_size_2 = null;
                this.matrix_result = null;
            }
        },
        created() {
            EventBus.$on('MATRIX_SIZE_DECLARED', this.assignMatrixSize);
            EventBus.$on('NEW_CALCULATION', this.resetForm);
            EventBus.$on('START_LOADING', () => {
                this.loading = true;
            });
            EventBus.$on('END_LOADING', () => {
                this.loading = false;
            });
        }
    }
</script>

<style lang="scss" scoped>

</style>