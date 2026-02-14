<template>
    <div class="w-full h-[400px]">
        <v-chart class="chart" :option="chartOption" autoresize />
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { use } from 'echarts/core';
import { CanvasRenderer } from 'echarts/renderers';
import { BarChart } from 'echarts/charts';
import {
    TitleComponent,
    TooltipComponent,
    GridComponent,
    LegendComponent
} from 'echarts/components';
import VChart from 'vue-echarts';

use([
    CanvasRenderer,
    BarChart,
    TitleComponent,
    TooltipComponent,
    GridComponent,
    LegendComponent
]);

const props = defineProps<{
    data: Array<{
        name: string;
        value: number;
        type: string;
        category?: string;
    }>;
}>();

const chartOption = computed(() => {
    if (!props.data || props.data.length === 0) return {};

    // Helper text formatter
    const formatLabel = (value: number) => {
        return value.toFixed(1);
    };

    const categories = props.data.map(item => item.name);
    
    // Waterfall Logic
    const values = props.data.map(item => item.value);
    
    const placeholders = [];
    const barValues = [];
    
    let currentHeight = 0;
    
    for (let i = 0; i < props.data.length; i++) {
        const item = props.data[i];
        
        if (i === 0) {
            // First bar (Total)
            placeholders.push(0);
            barValues.push(item.value);
            currentHeight = item.value;
        } else if (item.type === 'total' || item.type === 'subtotal' || item.type === 'final') {
            // Solid bars (Results) start from 0
            placeholders.push(0);
            barValues.push(item.value);
            currentHeight = item.value; // Reset height for next steps
        } else {
            // Loss bars (Floating)
            currentHeight -= item.value;
            placeholders.push(currentHeight);
            barValues.push(item.value);
        }
    }

    return {
        tooltip: {
            trigger: 'axis',
            axisPointer: { type: 'shadow' },
            formatter: (params: any) => {
                let tar;
                if (params[1].value !== '-') {
                    tar = params[1];
                } else {
                    tar = params[0];
                }
                return `${tar.name}<br/>${tar.seriesName} : ${tar.value} Hrs`;
            }
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            top: '10%',
            containLabel: true
        },
        xAxis: {
            type: 'category',
            splitLine: { show: false },
            data: categories,
            axisLabel: {
                interval: 0,
                rotate: 25, // Slight rotation to prevent overlapping
                fontSize: 11
            }
        },
        yAxis: {
            type: 'value',
            name: 'Hours',
            splitLine: {
                lineStyle: {
                    type: 'dashed',
                    color: '#eee'
                }
            }
        },
        series: [
            {
                name: 'Placeholder',
                type: 'bar',
                stack: 'Total',
                itemStyle: {
                    borderColor: 'transparent',
                    color: 'transparent'
                },
                emphasis: {
                    itemStyle: {
                        borderColor: 'transparent',
                        color: 'transparent'
                    }
                },
                data: placeholders
            },
            {
                name: 'Time',
                type: 'bar',
                stack: 'Total',
                barMaxWidth: 60,
                label: {
                    show: true,
                    position: 'top', // Show label on top for visibility
                    formatter: (p: any) => p.value > 0 ? p.value.toFixed(1) : '',
                    fontWeight: 'bold',
                    color: 'inherit' 
                },
                itemStyle: {
                     borderRadius: [4, 4, 4, 4],
                     color: (params: any) => {
                         const type = props.data[params.dataIndex].type;
                         const category = props.data[params.dataIndex].category;
                         
                         // Professional Palette
                         if (type === 'total') return '#3b82f6'; // Blue
                         if (type === 'final') return '#22c55e'; // Green
                         if (type === 'subtotal') return '#64748b'; // Slate Gray for Subtotals
                         
                         // Losses
                         if (category === 'availability') return '#ef4444'; // Red
                         if (category === 'performance') return '#f97316'; // Orange
                         if (category === 'quality') return '#eab308'; // Yellow
                         
                         return '#ef4444';
                     }
                },
                data: barValues
            }
        ]
    };
});
</script>

<style scoped>
.chart {
    height: 100%;
    width: 100%;
}
</style>
