<template>
    <div>
        <div class="text-center mb-5">
            <button class="btn btn-dark" @click="matrixEncodeDecode">{{encoded ? 'decode' : 'encode'}}</button>
            <button class="btn btn-dark" @click="newProcess">multiply new matrices</button>
        </div>
        <table v-if="encoded">
            <tr v-for="row in rows_size" :key="row">
                <td v-for="column in columns_size" :key="column">
                    {{matrix_encoded[row - 1][column - 1]}}
                </td>
            </tr>
        </table>
        <table v-else>
            <tr v-for="row in rows_size" :key="row">
                <td v-for="column in columns_size" :key="column">
                    {{matrix[row - 1][column - 1]}}
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
    import EventBus from '@/EventBus';

    export default {
        data() {
            return {
                matrix: null,
                matrix_encoded: null,
                encoded: true,
                rows_size: null,
                columns_size: null
            }
        },
        props: ['matrices'],
        methods: {
            matrixEncodeDecode() {
                this.encoded = !this.encoded;
            },
            newProcess() {
                EventBus.$emit('NEW_CALCULATION');
            }
        },
        created() {
            this.matrix = this.matrices.matrix_numeric;
            this.matrix_encoded = this.matrices.matrix_encoded;
            this.rows_size = this.matrix.length;
            this.columns_size = this.matrix[0].length;
        }
    }
</script>

<style lang="scss" scoped>
    table{
        border-collapse: collapse;
        margin: 0 auto;
    }

    td{
        border: 1px solid black;
        padding: 15px;
        font-size: 22px;
    }

    tr:first-child td{
        border-top: 0;
    }

    tr:last-child td{
        border-bottom: 0;
    }

    td:first-child{
        border-left: 0;
    }

    td:last-child{
        border-right: 0;
    }
</style>