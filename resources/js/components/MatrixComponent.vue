<template>
    <div>
        <table class="table">
            <tr v-for="rows in rows_size" :key="rows">
                <matrix-item 
                    v-for="columns in columns_size" 
                    :key="columns"
                    v-model="matrix[rows - 1][columns - 1]"
                    @input="updateMatrix"
                ></matrix-item>
            </tr>
        </table>
    </div>
</template>

<script>
    import EventBus from '@/EventBus';
    import MatrixItem from './MatrixItemInput';

    export default {
        data() {
            return {
                rows_size: null,
                columns_size: null,
                matrix: [],
                show: false
            }
        },
        props: ['size', 'value'],
        components: {
            MatrixItem,
        },
        methods: {
            updateMatrix() {
                this.$emit('UPDATE_MATRIX', this.matrix);
            }
        },
        created() {
            if (this.size) {
                this.rows_size = parseInt(this.size.rows);
                this.columns_size = parseInt(this.size.columns);
                this.matrix = new Array(this.rows_size);

                for (let i = 0; i < this.rows_size; i++) {
                    this.matrix[i] = new Array(this.columns_size);
                }
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>