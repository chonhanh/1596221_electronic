<div class="form-group">
    <div class="card">
        <div class="card-header bg-primary text-sm text-uppercase text-white font-weight-700">Hồ sơ ứng viên</div>
        <div class="card-body">
            <div class="form-group">
                <div class="form-row">
                    <div class="col-6">
                        <label class="form-label font-weight-500">Họ và chữ lót:</label>
                        <input type="text" class="form-control text-sm" id="first_name" name="dataPostingInfo[first_name]" placeholder="Họ & chữ lót" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label font-weight-500">Tên:</label>
                        <input type="text" class="form-control text-sm" id="last_name" name="dataPostingInfo[last_name]" placeholder="Tên" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <div class="col-6">
                        <label class="form-label font-weight-500" for="birthday">Ngày sinh:</label>
                        <input type="text" class="form-control max-date text-sm" id="birthday" name="dataPostingInfo[birthday]" placeholder="Ngày/tháng/năm sinh" required readonly autocomplete="off">
                    </div>
                    <div class="col-6">
                        <label class="form-label font-weight-500">Giới tính:</label>
                        <select class="select-gender custom-select text-sm cursor-pointer" name="dataPostingInfo[gender]" id="gender" required>
                            <option value="">Chọn giới tính</option>
                            <option value="1">Nam</option>
                            <option value="2">Nữ</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-row">
                    <div class="col-6">
                        <label class="form-label font-weight-500" for="phone">Điện thoại:</label>
                        <input type="text" class="form-control text-sm" id="phone" name="dataPostingInfo[phone]" placeholder="Điện thoại" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label font-weight-500" for="email">Email:</label>
                        <input type="text" class="form-control text-sm" id="email" name="dataPostingInfo[email]" placeholder="Email" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label font-weight-500" for="address">Địa chỉ:</label>
                <input type="text" class="form-control text-sm" id="address" name="dataPostingInfo[address]" placeholder="Địa chỉ" required>
            </div>
        </div>
    </div>
</div>