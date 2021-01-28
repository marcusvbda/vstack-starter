export default function () {
	return {
		resource_id: null,
		status_qty: {},
		status_leads: {},
		total: 0,
		get_params: {},
		permissions: {
			can_edit: false,
			use_tags: false,
		},
		progress_color: [
			{ color: '#f56c6c', percentage: 20 },
			{ color: '#e6a23c', percentage: 40 },
			{ color: '#5cb87a', percentage: 60 },
			{ color: '#1989fa', percentage: 80 },
			{ color: '#6f7ad3', percentage: 100 },
		]
	}
}
