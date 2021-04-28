<template>
	<div class="d-flex flex-wrap">
		<div class="d-flex full-width align-items-center">
			<img src="/images/no-image-user.png" class="user-image-round mr-3" alt="...">
			<el-input
				@keyup.enter.native.prevent="store"
				placeholder="Enter comment"
				clearable
				class="full-width input-round ml-10px"
				v-model="comment.content">
			</el-input>

			<el-button
				@click="store"
				class="send-button"
				type="text"
				icon="el-icon-position">
			</el-button>
		</div>
	</div>
</template>

<script>
	import cloneDeep from 'lodash/cloneDeep'

	export default {
		name: 'BaseCommentForm',
		props: {
			postId: {
				required: true
			},
			parentId: {
				default: null
			},
			level: {
				required: true,
				type: Number
			}
		},
		data() {
			return {
				loading: false,
				comment: {
					content: null,
					parent_id: this.parentId,
					post_id: this.postId,
					level: this.level
				},
			}
		},
		methods: {
			store() {
				this.loading = true

				if (!this.comment.content) {
					this.$notify.error({
			          	title: 'Error',
			          	message: 'Enter a comment first'
			        })

			        return
				}

				let postData = cloneDeep(this.comment)

				this.$API.PostComment.store(postData)
				.then(res => {
					if (res.data) {
						this.$ED.fire('COMMENT_CREATED', res.data)

						this.resetForm()
					}
				})
				.catch(err => {
					this.$notify.error({
			          	title: 'Error',
			          	message: 'Failed to create new comment. Please report this to your administrator.'
			        })

					console.log(err)
				})
				.finally(_ => {
					this.loading = false
				})
			},
			resetForm() {
				this.comment = {
					content: null,
					parent_id: null,
					post_id: this.postId,
					level: this.level
				}
			}
		}
	}
</script>

<style lang="scss">
	
</style>