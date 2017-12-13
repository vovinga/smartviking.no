<ul class="iModuleUL" id="iAnalyticsSearchWrapper">

    <li>
        <ul class="iModuleAdminMenu">
            <li class="selected">Dropbox</li>
            <li>Google Drive</li>
            <li>SkyDrive</li>
            <li>CSV</li>
        </ul>
        <div class="content">
            <ul class="iModuleAdminWrappers">
                <li>
                	<div>
                        <h1>Dropbox Configuration</h1>
                    </div>
                    <div class="help">After creating your Dropbox App (with Full access type) in <a href="https://www.dropbox.com/developers/apps" target="_blank">Dropbox Apps</a>, copy your App key and App secret here. You can watch a video tutorial <a href="http://screencast.com/t/zDKbRmHe7" target="_blank">here</a> or you can refer to the User Documentation for instructions on the setup.</div>
                    <div class="iModuleFields">
                    	<table>
                        	<tr>
                            	<td>
                    				<label for="AnyPortDropboxEnable">Enable Dropbox</label>
                        		</td>
                                <td>
                                	<select id="AnyPortDropboxEnable" name="AnyPort[Settings][Dropbox][Enable]">
                                	<option value="1"<?php echo (empty($data['AnyPort']['Settings']['Dropbox']['Enable'])) ? '' : (($data['AnyPort']['Settings']['Dropbox']['Enable'] == true) ? ' selected="selected"' : ''); ?>>Yes</option>
                                    <option value="0"<?php echo (empty($data['AnyPort']['Settings']['Dropbox']['Enable'])) ? ' selected="selected"' : (($data['AnyPort']['Settings']['Dropbox']['Enable'] == false) ? ' selected="selected"' : ''); ?>>No</option>
                                    </select>
                                </td>
                        	</tr>
                        	<tr>
                            	<td>
                    				<label for="AnyPortDropboxAppKey">App key:</label>
                                </td>
                                <td>
                    				<input type="text" id="AnyPortDropboxAppKey" name="AnyPort[Settings][Dropbox][AppKey]" value="<?php echo (empty($data['AnyPort']['Settings']['Dropbox']['AppKey'])) ? '' : $data['AnyPort']['Settings']['Dropbox']['AppKey']; ?>" />
                        		</td>
                        	</tr>
                            <tr>
                            	<td>
                        			<label for="AnyPortDropboxAppSecret">App secret:</label>
                                </td>
                                <td>
                    				<input type="text" id="AnyPortDropboxAppSecret" name="AnyPort[Settings][Dropbox][AppSecret]" value="<?php echo (empty($data['AnyPort']['Settings']['Dropbox']['AppSecret'])) ? '' : $data['AnyPort']['Settings']['Dropbox']['AppSecret']; ?>" />
                        		</td>
                        	</tr>
                            <tr>
                            	<td>
                        			<label for="AnyPortDropboxWorkingFolder">Working folder:</label>
                        		</td>
                                <td>
                    				<input type="text" id="AnyPortDropboxWorkingFolder" name="AnyPort[Settings][Dropbox][WorkingFolder]" value="<?php echo (empty($data['AnyPort']['Settings']['Dropbox']['WorkingFolder'])) ? '' : $data['AnyPort']['Settings']['Dropbox']['WorkingFolder']; ?>" />
                        		</td>
                        	</tr>
                        </table>
                    </div>
                </li>
                <li>
               		<div>
                        <h1>Google Drive Configuration</h1>
                    </div>
                    <div class="help">After creating your Google API Project in <a href="https://code.google.com/apis/console/" target="_blank">Google APIs Console</a>, copy your Client ID and Client secret here. Make sure to add "Drive API" and "Drive SDK" in "Services" and set <strong><?php echo (str_replace('/admin', '', (!empty($_SERVER['HTTPS']) ? HTTPS_SERVER : HTTP_SERVER) . 'vendors/anyport/gdrivecallback.php')); ?></strong> as your redirect URI. You can watch a video tutorial <a href="http://screencast.com/t/U55KHLJn8sY" target="_blank">here</a> or you can refer to the User Documentation for instructions on the setup.</div>
                    <div class="iModuleFields">
                    	<table>
                        	<tr>
                            	<td>
                    				<label for="AnyPortGoogleDriveEnable">Enable Google Drive</label>
                        		</td>
                                <td>
                                	<select id="AnyPortGoogleDriveEnable" name="AnyPort[Settings][GoogleDrive][Enable]">
                                	<option value="1"<?php echo (empty($data['AnyPort']['Settings']['GoogleDrive']['Enable'])) ? '' : (($data['AnyPort']['Settings']['GoogleDrive']['Enable'] == true) ? ' selected="selected"' : ''); ?>>Yes</option>
                                    <option value="0"<?php echo (empty($data['AnyPort']['Settings']['GoogleDrive']['Enable'])) ? ' selected="selected"' : (($data['AnyPort']['Settings']['GoogleDrive']['Enable'] == false) ? ' selected="selected"' : ''); ?>>No</option>
                                    </select>
                                </td>
                        	</tr>
                            <tr>
                            	<td>
                        			<label for="AnyPortGoogleDriveClientId">Client ID:</label>
                                </td>
                                <td>
                    				<input type="text" id="AnyPortGoogleDriveClientId" name="AnyPort[Settings][GoogleDrive][ClientId]" value="<?php echo (empty($data['AnyPort']['Settings']['GoogleDrive']['ClientId'])) ? '' : $data['AnyPort']['Settings']['GoogleDrive']['ClientId']; ?>" />
                                </td>
                        	</tr>
                            <tr>
                            	<td>
                        			<label for="AnyPortGoogleDriveClientSecret">Client secret:</label>
                        		</td>
                                <td>
                    				<input type="text" id="AnyPortGoogleDriveClientSecret" name="AnyPort[Settings][GoogleDrive][ClientSecret]" value="<?php echo (empty($data['AnyPort']['Settings']['GoogleDrive']['ClientSecret'])) ? '' : $data['AnyPort']['Settings']['GoogleDrive']['ClientSecret']; ?>" />
                        		</td>
                        	</tr>
                            <tr>
                            	<td>
                        			<label for="AnyPortGoogleDriveWorkingFolder">Working folder:</label>
                        		</td>
                                <td>
                    				<input type="text" id="AnyPortGoogleDriveWorkingFolder" name="AnyPort[Settings][GoogleDrive][WorkingFolder]" value="<?php echo (empty($data['AnyPort']['Settings']['GoogleDrive']['WorkingFolder'])) ? '' : $data['AnyPort']['Settings']['GoogleDrive']['WorkingFolder']; ?>" />
                        		</td>
                        	</tr>
                        </table>
                    </div>
                </li>
                <li>
               		<div>
                        <h1>SkyDrive Configuration</h1>
                    </div>
                    <div class="help">After creating your Windows Live Application in <a href="https://manage.dev.live.com/AddApplication.aspx?tou=1" target="_blank">Live Connect Developer Center</a>, copy your Client ID and Client secret here. Make sure to set <strong><?php echo ((!empty($_SERVER['HTTPS']) ? 'https://' : 'http://').$_SERVER['SERVER_NAME'].'/'); ?></strong> as your Redirect domain in your "API Settings". You can watch a video tutorial <a href="http://screencast.com/t/SPYF9FOO" target="_blank">here</a> or you can refer to the User Documentation for instructions on the setup.</div>
                    <div class="iModuleFields">
                        <table>
                        	<tr>
                            	<td>
                    				<label for="AnyPortSkyDriveEnable">Enable SkyDrive</label>
                        		</td>
                                <td>
                                	<select id="AnyPortSkyDriveEnable" name="AnyPort[Settings][SkyDrive][Enable]">
                                	<option value="1"<?php echo (empty($data['AnyPort']['Settings']['SkyDrive']['Enable'])) ? '' : (($data['AnyPort']['Settings']['SkyDrive']['Enable'] == true) ? ' selected="selected"' : ''); ?>>Yes</option>
                                    <option value="0"<?php echo (empty($data['AnyPort']['Settings']['SkyDrive']['Enable'])) ? ' selected="selected"' : (($data['AnyPort']['Settings']['SkyDrive']['Enable'] == false) ? ' selected="selected"' : ''); ?>>No</option>
                                    </select>
                                </td>
                        	</tr>
                            <tr>
                            	<td>
                        			<label for="AnyPortSkyDriveClientId">Client ID:</label>
                                </td>
                                <td>
                    				<input type="text" id="AnyPortSkyDriveClientId" name="AnyPort[Settings][SkyDrive][ClientId]" value="<?php echo (empty($data['AnyPort']['Settings']['SkyDrive']['ClientId'])) ? '' : $data['AnyPort']['Settings']['SkyDrive']['ClientId']; ?>" />
                                </td>
                        	</tr>
                            <tr>
                            	<td>
                        			<label for="AnyPortSkyDriveClientSecret">Client secret:</label>
                        		</td>
                                <td>
                    				<input type="text" id="AnyPortSkyDriveClientSecret" name="AnyPort[Settings][SkyDrive][ClientSecret]" value="<?php echo (empty($data['AnyPort']['Settings']['SkyDrive']['ClientSecret'])) ? '' : $data['AnyPort']['Settings']['SkyDrive']['ClientSecret']; ?>" />
                        		</td>
                        	</tr>
                            <tr>
                            	<td>
                        			<label for="AnyPortSkyDriveWorkingFolder">Working folder:</label>
                        		</td>
                                <td>
                    				<input type="text" id="AnyPortSkyDriveWorkingFolder" name="AnyPort[Settings][SkyDrive][WorkingFolder]" value="<?php echo (empty($data['AnyPort']['Settings']['SkyDrive']['WorkingFolder'])) ? '' : $data['AnyPort']['Settings']['SkyDrive']['WorkingFolder']; ?>" />
                        		</td>
                        	</tr>
                        </table>
                    </div>
                </li>
                <li>
                	<div>
                        <h1>CSV Configuration</h1>
                    </div>
                    <div class="help"></div>
                    <div class="iModuleFields">
                    	<table>
                        	<tr>
                            	<td>
                    				<label for="AnyPortCSVColumnSeparator">Column Separator</label><br />
                                    <span class="help">The default value is comma (,) but you can set it anything you like. The most common ones are comma (,) and semicolon (&#59;)</span>
                        		</td>
                                <td>
                                	<input id="AnyPortCSVColumnSeparator" type="text" name="AnyPort[Settings][CSV][ColumnSeparator]" value="<?php echo (empty($data['AnyPort']['Settings']['CSV']['ColumnSeparator'])) ? '' : $data['AnyPort']['Settings']['CSV']['ColumnSeparator']; ?>" placeholder="," />
                                </td>
                        	</tr>
                        </table>
                    </div>
                </li>
            </ul>
        </div>
    </li>
</ul>