import axios from 'axios'

export default {
	/**
	 * API endpoint to create new post comment
	 *
	 * @param postData <object> - the data to be saved
	 *
	 * @return Promise
	 */
	store(postData) {
		return axios.post('/post-comment', postData)
	},

	/**
	 * API endpoint to fetch list of Address Typess
	 *
	 * @param postData <object> - the data to be saved
	 *
	 * @return Promise
	 */
	fetch(postData) {
		return axios.post(`/post-comment/fetch-comments`, postData)
	}
}
