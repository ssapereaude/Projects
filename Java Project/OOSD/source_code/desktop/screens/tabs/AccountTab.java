/* 
 * Name: Filip Melka & Temur Rustamov
 * Date: April 2024
 */

package screens.tabs;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.ResultSetMetaData;
import java.sql.SQLException;
import javax.swing.JOptionPane;
import components.Button;
import components.InfoPanel;
import utils.Colors;
import utils.DB;
import utils.Fonts;
import utils.User;
import utils.Window;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

public class AccountTab extends Tab implements ActionListener {

    private final int MARGIN_TOP = PADDING_Y + TITLE_HEIGHT + 40;
    private final int INFO_PANEL_WIDTH = 200;
    private final int INFO_PANEL_HEIGHT = 60;
    private final int INFO_PANEL_GAP = (WIDTH - 2 * PADDING_X - 3 * INFO_PANEL_WIDTH);

    InfoPanel[] details;
    Button deleteBtn;

    public void actionPerformed(ActionEvent ev) {
        if (ev.getSource() == deleteBtn) {
            deleteBtn.setIsEnabled(false);

            int dialogButton = JOptionPane.YES_NO_OPTION;
            int dialogResult = JOptionPane.showConfirmDialog(this, "Are you sure you want to delete your account?",
                    "Confirmation", dialogButton);
            if (dialogResult == JOptionPane.YES_OPTION) {
                /* delete account */
                Connection connection = null;
                PreparedStatement pstat = null;

                try {
                    connection = DriverManager.getConnection(DB.URL, DB.USER, DB.PASSWORD);

                    /* delete user */
                    pstat = connection.prepareStatement("DELETE FROM users WHERE username = ?");
                    pstat.setString(1, User.getUsername());
                    pstat.executeUpdate();
                } catch (SQLException e) {
                    System.out.println(e.getMessage());
                } finally {
                    try {
                        pstat.close();
                        connection.close();
                    } catch (SQLException e) {
                        System.out.println(e.getMessage());
                    }
                }

                /* open up login screen */
                Window.logOut();

            } else {
                deleteBtn.setIsEnabled(true);
            }
        }
    }

    private void fetchData(Tab tab) {

        Connection connection = null;
        PreparedStatement pstat = null;
        ResultSet resultSet = null;

        try {
            connection = DriverManager.getConnection(DB.URL, DB.USER, DB.PASSWORD);
            pstat = connection.prepareStatement(
                    "SELECT users.username as Username, users.email as Email, users.joined as Joined, users.balance as Balance, COUNT(results.id) as Games, (SELECT MAX(multiplier * bet) FROM results) AS Biggest_WIN FROM users INNER JOIN results ON results.username = users.username WHERE users.username = ?");
            pstat.setString(1, User.getUsername());

            resultSet = pstat.executeQuery();
            ResultSetMetaData metaData = resultSet.getMetaData();
            int noOfColumns = metaData.getColumnCount();

            details = new InfoPanel[noOfColumns];

            resultSet.next();
            String label;
            String text;

            for (int i = 1; i <= noOfColumns; i++) {
                label = metaData.getColumnLabel(i).toString().replaceAll("_", " ");
                if (resultSet.getObject(i) != null) {
                    text = resultSet.getObject(i).toString();
                } else {
                    text = "0.00";
                }
                if (label.compareTo("Balance") == 0 || label.compareTo("Biggest WIN") == 0) {
                    text += 00;
                    text = "€ " + text.substring(0, text.indexOf('.') + 3);
                }

                details[i - 1] = new InfoPanel(label, text,
                        INFO_PANEL_WIDTH, INFO_PANEL_HEIGHT);
                details[i - 1].setBounds(PADDING_X + ((i - 1) % 2) * (INFO_PANEL_GAP + INFO_PANEL_WIDTH),
                        MARGIN_TOP + ((int) (Math.floor((i - 1) / 2))) * (40 + INFO_PANEL_HEIGHT), INFO_PANEL_WIDTH,
                        INFO_PANEL_HEIGHT);

                tab.add(details[i - 1]);
            }

        } catch (Exception e) {
            e.printStackTrace();
        } finally {
            try {
                pstat.close();
                connection.close();
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }

    }

    public AccountTab() {
        super("Manage Account");

        fetchData(this);

        deleteBtn = new Button("Delete Account");
        deleteBtn.setBackground(Colors.RED);
        deleteBtn.setForeground(Colors.BG);
        deleteBtn.setBounds(PADDING_X, Window.WINDOW_HEIGHT - PADDING_Y - 150, 250,
                42);
        deleteBtn.setFont(Fonts.DEFAULT);
        deleteBtn.addActionListener(this);
        this.add(deleteBtn);

    }

}
