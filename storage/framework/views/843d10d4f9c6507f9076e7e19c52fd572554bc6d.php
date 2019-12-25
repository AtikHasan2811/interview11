<?php $__env->startSection('content'); ?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-3">
						<div class="list-group">
						  	<!-- <a class="list-group-item <?php if(\Request::route()->getName()=='admin'): ?> active <?php endif; ?>" href="/admin/">Overview</a>
						  	<a class="list-group-item <?php if(\Request::route()->getName()=='admin/manage-user'): ?> active <?php endif; ?>" href="/admin/manage-user/">Manage User</a>
						  	<a class="list-group-item <?php if(\Request::route()->getName()=='admin/membership-plan'): ?> active <?php endif; ?>" href="/admin/membership-plan">Membership Plan</a>
						  	<a class="list-group-item <?php if(\Request::route()->getName()=='admin/free-sign-up'): ?> active <?php endif; ?>" href="/admin/free-sign-up">Free Sign Up</a> -->
						</div>
					</div>
					<div class="col-md-9">


					<ul class="list-inline">
						<li>
							<a class="btn btn-primary" href="/admin/manage-user/create"> Create Account</a>
						</li>
						<li>
							<form>
								<input class="form-control" type="text" name="search" placeholder="Search">
								<button class="pull-right" style=" position: relative; margin-top: -27px; border: 0px; background: 0px;  padding-right: 12px; outline: none !important;"> <i class="glyphicon glyphicon-search"></i> </button>
							</form>
						</li>
					</ul>

					<table class="table table-bordered"> 
						<thead> 
							<tr> 
								<th>Group Name</th>
								<th>Group Type</th>
								<th>Account Name</th>
								<th>Post Text</th>
								<th>Time</th>
							</tr> 
						</thead> 
						<tbody> 
							<?php 


								$records=\Bulkly\BufferPosting::get();
							 ?>
							<?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr> 
							
								<td><?php echo e(!empty($record->groupInfo->name)?$record->groupInfo->name:""); ?></td> 
								<td><?php echo e(!empty($record->groupInfo->type)?$record->groupInfo->type:""); ?></td> 
								<td><?php echo e(!empty($record->accountInfo->name)?$record->accountInfo->name:""); ?></td> 
								<td><?php echo e($record->post_text); ?></td>
								<td>
									<?php echo e($record->created_at); ?>

								</td> 
								

							</tr>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						 </tbody> 
					 </table>

					 
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>