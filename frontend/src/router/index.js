import Vue from 'vue'
import Router from 'vue-router'
import Login from '@/components/Login'
import Expenses from '@/components/Expenses'
import Income from '@/components/Income'
import Chart from '@/components/Chart'
import User from '@/components/User'

Vue.use(Router)

export default new Router({
	mode: 'history',
	routes: [
		{
			path: '/login',
			name: 'Login',
			component: Login
		},
		{
			path: '/',
			name: 'Expenses',
			component: Expenses
		},
		{
			path: '/expenses',
			name: 'Expenses',
			component: Expenses
		},
		{
			path: '/income',
			name: 'Income',
			component: Income
		},
		{
			path: '/chart',
			name: 'Chart',
			component: Chart
		},
		{
			path: '/user',
			name: 'User',
			component: User
		},
	]
})