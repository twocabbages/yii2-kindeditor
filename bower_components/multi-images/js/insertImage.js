/**
 * 移除图片接口
 * @param string unid ID的字符串
 * @param integer index 索引数
 * @param integer attachId 附件ID
 * @return void
 */
removeImage = function (obj, id) {

    // 移除附件ID数据
    upAttachVal(obj, 'del', id);

    // 移除图像
    $('#li_' + id).remove();

    // 动态设置数目
    upNumVal(obj, 'dec');
}
/**
 * 更新附件表单值
 * @return void
 */
upAttachVal = function (obj, type, attachId) {

    var _attach_ids = $(obj);
    var attachVal = _attach_ids.val();
    var attachArr = attachVal.split(',');
    var newArr = [];

    for (var i in attachArr) {
        if (attachArr[i] !== '' && attachArr[i] !== attachId.toString()) {
            newArr.push(attachArr[i]);
        }
    }
    type === 'add' && newArr.push(attachId);
    _attach_ids.val(newArr.join(','));
}
/**
 * 更新上传显示数目
 * @param string unid 唯一ID
 * @param string type 更新类型，inc增加；dec减少
 * @return void
 */
upNumVal = function (obj, unid, type) {


    var _uploadNum = $('#upload_num_' + unid),
        _totalNum = $('#total_num_' + unid);
    switch (type) {
        case 'inc':
            // 动态设置数目 - 增加
            _uploadNum.html(parseInt(_uploadNum.html()) + 1);
            _totalNum.html(parseInt(_totalNum.html()) - 1);
            break;
        case 'dec':
            // 动态设置数目 - 减少
            _uploadNum.html(parseInt(_uploadNum.html()) - 1);
            _totalNum.html(parseInt(_totalNum.html()) + 1);
            break;
    }
}