<template>
	<div class="view-post">
		<div class="card" v-loading="loading">
			<div class="card-body">
				<div class="d-flex full-width align-items-center">
					<img src="/images/no-image-user.png" class="user-image-round" alt="...">
					<span class="user-meta-container">
						<span class="user-name text-gray">Thomas Shelby</span> 
						<br>
						<span class="timestamp text-gray">Apr 28, 2021 - 5:57 am (in 9 hours)</span>
					</span>
				</div>

				<div class="post-content text-gray">
					{{ pageData.post.content }}
				</div>

				<div class="mt-3 text-end">
					<el-button
						type="text">
						{{ totalCount }} Comments
					</el-button>
				</div>

				<!-- Comment Box Component -->
				<div>
					<base-comment-box
						v-for="com in comments"
						:key="com.id"
						:post-id="pageData.post.id"
						:comment="com">
					</base-comment-box>
				</div>	
				<!-- Comment Box Component -->

				<!-- Load More Button -->
				<div class="text-center">
					<el-button
						v-if="hasToLoad"
						type=text
						@click="loadMore">
						Load More...
					</el-button>
				</div>
				<!-- End of Load More Button -->

				<!-- Level One Comment -->
				<div class="mt-3">
					<base-comment-form
						:level="1"
						:post-id="pageData.post.id">
					</base-comment-form>
				</div>
				<!-- End of Level One Comment -->
			</div>
		</div>
	</div>
</template>

<script>
	import cloneDeep from 'lodash/cloneDeep'

	export default {
		name: 'ViewPost',
		props: {
			pageData: {
				type: Object,
				required: true
			}
		},
		data() {
			return {
				loading: false,
				level: 1,
				comments: [],
				totalCount: 0,
				offset: 0,
				hasToLoad: true
			}
		},
		created() {
			this.fetch()

			this.$ED.listen('COMMENT_CREATED', comment => {
				this.addItem(comment)
			})
		},
		methods: {
			loadMore() {
				this.offset += 10

				this.fetch(true)
			},
			fetch(loadMore = false) {
				this.loading = true

				let postData = {
					offset: this.offset
				}

				this.$API.PostComment.fetch(postData)
				.then(res => {
					if (!res.data.comments.length) {
						this.hasToLoad = false
						return
					}

					if (res.data) {
						this.totalCount = res.data.total_count
						if (loadMore) {
							this.comments = [ ...this.comments, ...res.data.comments]
						} else {
							this.comments = res.data.comments
						}

						if (this.comments.length < (this.offset + 10)) {
							this.hasToLoad = false
						}
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
			addItem(item) {
				item.children = []

				if (item.level == 1) {
					this.comments.unshift(item)
				}

				this.insertToTree(item, item.level, this.comments)
			},
			insertToTree(item, level, comments) {
				for (let x of comments) {
					if (x.level == (level - 1)) {
						if (x.id == item.parent_id) {
							x.children.unshift(item)

							return
						}

						continue
					}

					if (x.level < (level - 1)) {
						if (!!x.children) {
							this.insertToTree(item, level, x.children)
						}
					}
				}
			}
		}
	}
</script>

<style lang="scss">
	.view-post {
		margin: 10px 25%;
	}

	.send-button {
		position: absolute;
	    right: 30px;
	    font-size: 20px;
	}

	.comment-box {
		.el-card__body {
			padding: 10px !important;
			font-size: 12px;
		}
	}
</style>