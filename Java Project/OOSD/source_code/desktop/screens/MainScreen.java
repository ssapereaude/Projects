/* 
 * Name: Filip Melka & Temur Rustamov
 * Date: April 2024
 */

package screens;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.util.Date;
import javax.swing.JPanel;
import components.Sidebar;
import components.MysteryBoxFrame;
import screens.tabs.AccountTab;
import screens.tabs.PasswordTab;
import screens.tabs.PaymentsTab;
import screens.tabs.ResultsTab;
import screens.tabs.Tab;
import utils.DB;
import utils.User;
import utils.Window;

public class MainScreen extends JPanel {

    public enum Tabs {
        PAYMENTS,
        RESULTS,
        PASSWORD,
        ACCOUNT
    }

    private Tab currentTab;

    private boolean hasMysteryBox() {

        Date today = new Date();
        Date date = null;
        Connection connection = null;
        PreparedStatement pstat = null;
        ResultSet resultSet = null;
        try {

            connection = DriverManager.getConnection(DB.URL, DB.USER, DB.PASSWORD);
            pstat = connection.prepareStatement("SELECT nextMysteryBox FROM users WHERE username = ?");
            pstat.setString(1, User.getUsername());

            resultSet = pstat.executeQuery();

            resultSet.next();

            date = resultSet.getDate(1);

        } catch (Exception e) {
            e.printStackTrace();
        } finally {
            try {
                pstat.close();
                connection.close();
            } catch (Exception e) {
                e.printStackTrace();
            }
        }

        if (date == null)
            return false;

        return today.compareTo(date) >= 0;
    }

    public MainScreen() {
        Window.mainScreen = this;
        this.setLayout(null);
        this.setBounds(0, 0, Window.WINDOW_WIDTH, Window.WINDOW_HEIGHT);
        this.add(new Sidebar(this));

        hasMysteryBox();
        /* Daily Mystery Box */
        if (hasMysteryBox()) {
            new MysteryBoxFrame();
        }

        changeTab(Tabs.PAYMENTS);
    }

    public void changeTab(Tabs tab) {

        /* remove current tab */
        if (currentTab != null) {
            this.remove(currentTab);
            this.repaint();
            this.revalidate();
        }

        switch (tab) {
            case PAYMENTS:
                currentTab = new PaymentsTab();
                break;
            case RESULTS:
                currentTab = new ResultsTab();
                break;
            case PASSWORD:
                currentTab = new PasswordTab();
                break;
            case ACCOUNT:
                currentTab = new AccountTab();
                break;

            default:
                break;
        }

        /* add new tab */
        if (currentTab != null) {
            this.add(currentTab);
        }

    }

}
